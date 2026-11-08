<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class TanosvenySeeder extends Seeder
{
    public function run(): void
    {
        $npRows = array_map(static fn (array $row) => [
            'id' => (int) $row['id'],
            'nev' => $row['nev'],
        ], $this->readTsv(database_path('data/tanosvenyek/np.txt')));

        $telepulesRows = array_map(static fn (array $row) => [
            'id' => (int) $row['id'],
            'nev' => $row['nev'],
            'npid' => (int) $row['npid'],
        ], $this->readTsv(database_path('data/tanosvenyek/telepules.txt')));

        $utRows = [];

        foreach ($this->readTsv(database_path('data/tanosvenyek/ut.txt')) as $index => $row) {
            $utRows[] = [
                'azon' => $index + 1,
                'nev' => $row['nev'],
                'hossz' => $this->decimal($row['hossz']),
                'allomas' => (int) $row['allomas'],
                'ido' => $this->decimal($row['ido']),
                'vezetes' => (int) $row['vezetes'] !== 0,
                'telepulesid' => (int) $row['telepulesid'],
            ];
        }

        DB::transaction(function () use ($npRows, $telepulesRows, $utRows): void {
            DB::table('ut')->delete();
            DB::table('telepules')->delete();
            DB::table('np')->delete();

            DB::table('np')->insert($npRows);
            DB::table('telepules')->insert($telepulesRows);
            DB::table('ut')->insert($utRows);
        });
    }

    private function readTsv(string $path): array
    {
        $handle = fopen($path, 'rb');

        if ($handle === false) {
            throw new RuntimeException("Nem olvasható az adatfájl: {$path}");
        }

        $headers = fgetcsv($handle, 0, "\t");

        if ($headers === false) {
            fclose($handle);
            throw new RuntimeException("Hiányzik az adatfájl fejléce: {$path}");
        }

        $headers[0] = preg_replace('/^\xEF\xBB\xBF/', '', $headers[0]);
        $rows = [];

        while (($values = fgetcsv($handle, 0, "\t")) !== false) {
            if ($values === [null]) {
                continue;
            }

            if (count($values) !== count($headers)) {
                fclose($handle);
                throw new RuntimeException("Hibás oszlopszám az adatfájlban: {$path}");
            }

            $rows[] = array_combine($headers, array_map(static fn ($value) => trim((string) $value), $values));
        }

        fclose($handle);

        return $rows;
    }

    private function decimal(string $value): string
    {
        $normalized = str_replace(',', '.', $value);

        if (!is_numeric($normalized)) {
            throw new RuntimeException("Érvénytelen számérték az adatfájlban: {$value}");
        }

        return $normalized;
    }
}
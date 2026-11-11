<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class MakeAdmin extends Command
{
    protected $signature = 'app:make-admin {email : The existing account email address}';

    protected $description = 'Promote an existing account to administrator';

    public function handle(): int
    {
        $user = User::where('email', $this->argument('email'))->first();

        if (! $user) {
            $this->components->error('Nincs ilyen e-mail-címmel regisztrált felhasználó.');

            return self::FAILURE;
        }

        $password = $this->secret('Adj meg egy új admin jelszót (legalább 12 karakter)');

        if (! is_string($password) || strlen($password) < 12) {
            $this->components->error('A jelszónak legalább 12 karakteresnek kell lennie.');

            return self::FAILURE;
        }

        $confirmation = $this->secret('Jelszó megerősítése');

        if (! hash_equals($password, (string) $confirmation)) {
            $this->components->error('A megadott jelszavak nem egyeznek.');

            return self::FAILURE;
        }

        $user->forceFill([
            'role' => 'admin',
            'password' => Hash::make($password),
        ])->save();

        $this->components->info('Az admin szerepkör beállítva.');

        return self::SUCCESS;
    }
}
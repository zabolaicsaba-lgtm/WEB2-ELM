<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('persons')->insert(['name' => 'Mark Schmidt', 'age' => '35', 'height' => '172.3']);
        DB::table('persons')->insert(['name' => 'John Brown', 'age' => '40', 'height' => '168.5']);
        DB::table('persons')->insert(['name' => 'Greta Rose', 'age' => '42', 'height' => '165.8']);
    }
}

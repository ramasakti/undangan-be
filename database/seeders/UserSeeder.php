<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            "name" => "Rama Sakti",
            "email" => "ramasakti1337@gmail.com",
            "username" => "ramasakti",
            "password" => bcrypt("ramasakti")
        ]);
        DB::table('users')->insert([
            "name" => "Intan Cimit",
            "email" => "intanfajar78@gmail.com",
            "username" => "intanfajar78",
            "password" => bcrypt("intanfajar78")
        ]);
    }
}

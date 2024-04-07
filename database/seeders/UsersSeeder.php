<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert([
            'nombre'      => "Developer",
            'apellido'    => "Wolke sas",
            'email'     => "desarrollador@wolke.com.co",
            'password'  => Hash::make('devkeller'),
            'role_id'  => 1,
        ]);
    }
}

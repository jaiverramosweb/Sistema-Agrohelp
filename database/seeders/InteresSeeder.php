<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InteresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('interes')->insert([
            'name'  => 'ibr',
            'valor' => 2.4
        ]);
        DB::table('interes')->insert([
            'name'  => 'corriente',
            'valor' => 2.3
        ]);
        DB::table('interes')->insert([
            'name'  => 'mora',
            'valor' => 2.5
        ]);
    }
}

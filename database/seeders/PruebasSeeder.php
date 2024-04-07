<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PruebasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        // DB::table('permissions')->insert([
        //     'name'          => 'Test' ,
        //     'module'         => 'test' 
        // ]);

        DB::table('modules')->insert([
            'jerarquia'             => 10,
            'name'                  => "Clientes",
            'icon'                  => "fab fa-users",
            'route'                 => "/config/custom-fields",
            'module_permissions'    => "custom_fields",
            'module_group'          => "clients_group",
        ]);

        // DB::table('form_entities')->insert([
        //     'name'          => 'Configuraciones' ,
        //     'key'         => 'config' 
        // ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('modules')->truncate();

        // GRUPO - Usuarios
        DB::table('modules')->insert([
            'group'                 => true,
            'name'                  => "Usuarios",
            'jerarquia'             => 1,
            'icon'                  => "fas fa-users",
            'route'                 => "users_group",
            'module_permissions'    => "users",
            'module_group'          => "0",
        ]);
        DB::table('modules')->insert([
            'name'                  => "Usuarios",
            'jerarquia'             => 2,
            'icon'                  => "fas fa-users",
            'route'                 => "/users",
            'module_permissions'    => "users",
            'module_group'          => "users_group",
        ]);
        DB::table('modules')->insert([
            'jerarquia'             => 3,
            'name'                  => "Permisos",
            'icon'                  => "fas fa-lock",
            'route'                 => "/permisos",
            'module_permissions'    => "permisos",
            'module_group'          => "users_group",
        ]);
        // DB::table('modules')->insert([
        //     'jerarquia'             => 4,
        //     'name'                  => "Test",
        //     'icon'                  => "fas fa-lock",
        //     'route'                 => "/permisos",
        //     'module_permissions'    => "test",
        //     'module_group'          => "users_group",
        // ]);
        //

        // Cientes
        DB::table('modules')->insert([
            'jerarquia'             => 2,
            'name'                  => "Clientes",
            'icon'                  => "fas fa-users",
            'route'                 => "/clients",
            'module_permissions'    => "clients",
            'module_group'          => "0",
        ]);


        // Productos
        DB::table('modules')->insert([
            'jerarquia'             => 3,
            'name'                  => "Productos",
            'icon'                  => "fas fa-product-hunt",
            'route'                 => "/productos",
            'module_permissions'    => "productos",
            'module_group'          => "0",
        ]);
        // DB::table('modules')->insert([
        //     'jerarquia'             => 10,
        //     'group'                 => true,
        //     'name'                  => "Clientes",
        //     'module_group'          => "0",
        //     'icon'                  => "fas fa-users",
        //     'route'                 => "clients_group",
        //     'module_permissions'    => "clients",
        // ]);
        // DB::table('modules')->insert([
        //     'jerarquia'             => 10,
        //     'name'                  => "Clientes",
        //     'icon'                  => "fab fa-users",
        //     'route'                 => "/config/custom-fields",
        //     'module_permissions'    => "clients",
        //     'module_group'          => "clients_group",
        // ]);
        //


        // GRUPO - Configuraciones
        // DB::table('modules')->insert([
        //     'jerarquia'             => 10,
        //     'group'                 => true,
        //     'name'                  => "Configuraciones",
        //     'module_group'          => "0",
        //     'icon'                  => "fas fa-cogs",
        //     'route'                 => "config_group",
        //     'module_permissions'    => "config",
        // ]);
        // DB::table('modules')->insert([
        //     'jerarquia'             => 1,
        //     'name'                  => "Campos personalizados",
        //     'icon'                  => "fab fa-wpforms",
        //     'route'                 => "/config/custom-fields",
        //     'module_permissions'    => "custom_fields",
        //     'module_group'          => "config_group",
        // ]);
        // DB::table('modules')->insert([
        //     'jerarquia'             => 2,
        //     'name'                  => "Modulos",
        //     'module_group'          => "0",
        //     'icon'                  => "fas fa-cogs",
        //     'route'                 => "/config/modules",
        //     'module_permissions'    => "modules",
        //     'module_group'          => "config_group",
        // ]);
        //

        // GRUPO - Modulos
        // DB::table('modules')->insert([
        //     'jerarquia'             => 10,
        //     'group'                 => true,
        //     'name'                  => "Modulos",
        //     'module_group'          => "0",
        //     'icon'                  => "fas fa-cogs",
        //     'route'                 => "config/modules",
        //     'module_permissions'    => "config",
        // ]);



        // DB::table('modules')->insert([
        //     'jerarquia'             => 100,
        //     'name'                  => "Pruebas",
        //     'icon'                  => "fas fa-vial",
        //     'route'                 => "/pruebas-johann",
        //     'module_permissions'    => "pruebas",
        //     'module_group'          => "0",
        // ]);



    }
}

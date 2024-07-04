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

        // GRUPO - Configuraciones
        DB::table('modules')->insert([
            'jerarquia'             => 3,
            'group'                 => true,
            'name'                  => "Configuraciones",
            'module_group'          => "0",
            'icon'                  => "fas fa-cogs",
            'route'                 => "config_group",
            'module_permissions'    => "config",
        ]);
        DB::table('modules')->insert([
            'jerarquia'             => 1,
            'name'                  => "Garantias",
            'icon'                  => "fab fa-wpforms",
            'route'                 => "/config/garantias",
            'module_permissions'    => "garantias",
            'module_group'          => "config_group",
        ]);
        DB::table('modules')->insert([
            'jerarquia'             => 2,
            'name'                  => "Documentación",
            'module_group'          => "0",
            'icon'                  => "fas fa-cogs",
            'route'                 => "/config/documentacion",
            'module_permissions'    => "documentacion",
            'module_group'          => "config_group",
        ]);
        DB::table('modules')->insert([
            'jerarquia'             => 3,
            'name'                  => "Medios de pagos",
            'module_group'          => "0",
            'icon'                  => "fas fa-wallet",
            'route'                 => "/config/metodo-pago",
            'module_permissions'    => "medio-pagos",
            'module_group'          => "config_group",
        ]);
        DB::table('modules')->insert([
            'jerarquia'             => 4,
            'name'                  => "Intereses",
            'module_group'          => "0",
            'icon'                  => "fas fa-money-check-alt",
            'route'                 => "/config/intereses",
            'module_permissions'    => "intereses",
            'module_group'          => "config_group",
        ]);
        DB::table('modules')->insert([
            'jerarquia'             => 4,
            'name'                  => "Mora",
            'module_group'          => "0",
            'icon'                  => "fas fa-money-check-alt",
            'route'                 => "/config/mora",
            'module_permissions'    => "mora",
            'module_group'          => "config_group",
        ]);
        DB::table('modules')->insert([
            'jerarquia'             => 5,
            'name'                  => "Asesores",
            'module_group'          => "0",
            'icon'                  => "fas fa-user",
            'route'                 => "/config/asesores",
            'module_permissions'    => "asesores",
            'module_group'          => "config_group",
        ]);
        DB::table('modules')->insert([
            'jerarquia'             => 6,
            'name'                  => "Cuentas Contables",
            'module_group'          => "0",
            'icon'                  => "fas fa-file-invoice-dollar",
            'route'                 => "/config/cuenta",
            'module_permissions'    => "cuenta",
            'module_group'          => "config_group",
        ]);

        // GRUPO - Pagos
        DB::table('modules')->insert([
            'jerarquia'             => 4,
            'group'                 => true,
            'name'                  => "Pagos",
            'module_group'          => "0",
            'icon'                  => "fas fa-money-check-alt",
            'route'                 => "pago_group",
            'module_permissions'    => "pago",
        ]);
        DB::table('modules')->insert([
            'jerarquia'             => 1,
            'name'                  => "Factura",
            'icon'                  => "fas fa-cash-register",
            'route'                 => "/pago/facturar",
            'module_permissions'    => "facturar",
            'module_group'          => "pago_group",
        ]);
        DB::table('modules')->insert([
            'jerarquia'             => 2,
            'name'                  => "Lista",
            'icon'                  => "fas fa-table",
            'route'                 => "/pago/lista",
            'module_permissions'    => "lista",
            'module_group'          => "pago_group",
        ]);


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
            'jerarquia'             => 5,
            'name'                  => "Línea de crédito",
            'icon'                  => "fas fa-credit-card",
            'route'                 => "/productos",
            'module_permissions'    => "productos",
            'module_group'          => "0",
        ]);

        // Productos
        DB::table('modules')->insert([
            'jerarquia'             => 6,
            'name'                  => "Solicitudes",
            'icon'                  => "fas fa-money-bill-alt",
            'route'                 => "/solicitudes",
            'module_permissions'    => "solicitudes",
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



        // DB::table('modules')->insert([
        //     'jerarquia'             => 2,
        //     'name'                  => "Tipos",
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

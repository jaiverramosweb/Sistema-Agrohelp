<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('roles')->truncate();

        DB::table('roles')->insert([
            'name'          => "Super Admin",
            'description'  => "Usuario desarrollador, tiene acceso a todos los permisos configurados.",
        ]);
        DB::table('roles')->insert([
            'name'          => "Administrador",
            'description'  => "Administrador del sistema ",
        ]);
        DB::table('roles')->insert([
            'name'          => "Operativo",
            'description'  => "Usuario operativo del sistema",
        ]);
        DB::table('roles')->insert([
            'name'          => "Cliente",
            'description'  => "Usuario cliente del sistema",
        ]);
        DB::table('roles')->insert([
            'name'          => "Nuevo Usuario",
            'description'  => "Nuevo usuario no cliente",
        ]);


        $permisos = '[
            {
                "name": "Usuarios",
                "module": "users"
            },
            {
                "name": "Roles y permisos",
                "module": "permisos"
            },
            {
                "name": "Clientes",
                "module": "clients"
            },
            {
                "name": "Productos",
                "module": "productos"
            },
            {
                "name": "Configuraciones",
                "module": "config"
            },
            {
                "name": "Garantias",
                "module": "garantias"
            },
            {
                "name": "Documentación",
                "module": "documentacion"
            },
            {
                "name": "Medio de pagos",
                "module": "medio-pagos"
            },
            {
                "name": "Solicitudes",
                "module": "solicitudes"
            }
        ]';

        $permisos = json_decode($permisos);

        // DB::table('permissions')->truncate();

        foreach ($permisos as $key) {
            DB::table('permissions')->insert([
                'name'          => $key->name,
                'module'          => $key->module
            ]);
        }

        $permissions = DB::table('permissions')
            ->select('*')
            ->get();

        foreach ($permissions as $key) {
            DB::table('role_permission')->insert([

                'fk_role_id'        => 1,
                'fk_permission_id'  => $key->id,

                'create'            => true,
                'read'              => true,
                'update'            => true,
                'delete'            => true,

            ]);
        }
    }
}

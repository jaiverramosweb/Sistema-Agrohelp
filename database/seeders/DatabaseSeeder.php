<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UsersSeeder::class,
            RolesAndPermissionsSeeder::class,
            ModulesSeeder::class,
            FormEntitiesSeeder::class,
            CustomFieldsSeeder::class,
            InteresSeeder::class
        ]);
    }
}

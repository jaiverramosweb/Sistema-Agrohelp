<?php

namespace Database\Seeders\Fields;

use Illuminate\Support\Facades\DB;

class UsersCustomFields 
{
    /**
     * Run the database seeds.
     */
    public static function run()
    {
        $form = DB::table('form_entities')
        ->where( 'key' , 'users' )
        ->select('id')
        ->first();
        $form_id = $form ? $form->id : 0;

        // Campos ESTATICOS
        DB::table('custom_fields')->insert([
            "id_input"        => "nombre",
            "fk_form_id"      => $form_id,
            "type_field"      => "static",
            "name"            => "nombre",
            "title"           => "Nombre",
            "type"            => "text",
            "class"           => "col-md-6 col-xs-12 col-sm-6",
            "icon"            => "fas fa-users",
            
        ]);
        DB::table('custom_fields')->insert([
            "id_input"              => "nombre",
            "fk_form_id"      => $form_id,
            "type_field"      => "static",
            "name"            => "nombre",
            "title"           => "Nombre",
            "type"            => "text",
            "class"           => "col-md-6 col-xs-12 col-sm-6",
            "icon"            => "fas fa-users",
            
        ]);
        DB::table('custom_fields')->insert([
            "id_input"              => "nombre",
            "fk_form_id"      => $form_id,
            "type_field"      => "static",
            "title"           => "Teléfono",
            "name"            => "nombre",
            "type"            => "text",
            "class"           => "col-md-6 col-xs-12 col-sm-6",
            "icon"            => "fas fa-users",
            
        ]);

        // Campos DINAMICOS
        DB::table('custom_fields')->insert([
            "id_input"        => "nombre",
            "fk_form_id"      => $form_id,
            "jerarquia"       => 2,
            "type_field"      => "dynamic",
            "name"            => "nombre",
            "title"           => "Prueba",
            "type"            => "text",
            "class"           => "col-md-6 col-xs-12 col-sm-6",
            "icon"            => "fas fa-users",
            
        ]);
        DB::table('custom_fields')->insert([
            "id_input"              => "nombre",
            "fk_form_id"      => $form_id,
            "jerarquia"       => 3,
            "type_field"      => "dynamic",
            "name"            => "nombre",
            "title"           => "Test",
            "type"            => "text",
            "class"           => "col-md-6 col-xs-12 col-sm-6",
            "icon"            => "fas fa-users",
            
        ]);
        DB::table('custom_fields')->insert([
            "id_input"              => "nombre",
            "fk_form_id"      => $form_id,
            "jerarquia"       => 1,
            "type_field"      => "dynamic",
            "name"            => "nombre",
            "title"           => "Texto ",
            "type"            => "text",
            "class"           => "col-md-6 col-xs-12 col-sm-6 ",
            "icon"            => "fas fa-cogs",
            
        ]);

    }
}

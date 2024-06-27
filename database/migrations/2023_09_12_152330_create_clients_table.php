<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            $table->integer('users_id')->nullable();
            $table->string('id_user_sap')->nullable();
            $table->string('id_prove_sap')->nullable();
            $table->string('nombre')->nullable();
            $table->string('apellido')->nullable();
            $table->string('segundo_nombre')->nullable();
            $table->string('segundo_apellido')->nullable();
            $table->string('tipo_documento')->nullable();
            $table->string('documento')->nullable();
            $table->string('email')->unique();
            $table->string('genero')->nullable();
            $table->string('tipo_persona')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('estado_persona')->nullable();
            $table->string('indicador_persona')->nullable();
            $table->integer('role_id')->nullable();

            $table->string('edad')->nullable();

            $table->string('ciudad_solicitud')->default('');
            $table->string('tipo_cliente')->default('');
            $table->string('tipo_declarante')->default('');
            $table->string('profesion')->default('');
            $table->string('empresa_donde_labora')->default('');
            $table->string('indicador')->default('');
            $table->string('nombre_negocio')->default('');
            $table->string('nombre_conyuge')->default('');
            $table->string('empresa_conyuge')->default('');
            $table->string('indicador_autorizacion')->default('');
            $table->string('domicilio')->default('');
            $table->string('direccion_comercial')->default('');
            $table->string('telefono_comercial')->default('');
            $table->string('direccion_judicial')->default('');
            $table->string('telefono_judicial')->default('');
            $table->string('representante')->default('');
            $table->string('representante_doc')->default('');
            $table->string('autorretenedor')->default('');
            $table->string('persona_pago')->default('');
            $table->string('direccion_pago')->default('');
            $table->string('telefono_pago')->default('');
            $table->string('dia_pago')->default('');
            $table->string('hora_pago')->default('');
            $table->string('comentatio_pago')->default('');
            $table->string('estado_civil')->default('');
            $table->string('direccion_recidencia')->default('');
            $table->string('telefono_recidencia')->default('');
            $table->string('ciudad_recidencia')->default('');
            $table->string('empresa')->default('');
            $table->string('empresa_direccion')->default('');
            $table->string('empresa_telefono')->default('');
            $table->string('cargo_actual')->default('');
            $table->string('antoguedad_empresa')->default('');
            $table->string('personas_cargo')->default('');
            $table->string('vivienda')->default('');
            $table->string('independiente')->default('');
            $table->string('camara_comercio')->default('');
            $table->string('ocupacion_conyuge')->default('');

            $table->string('firma_solicitud')->default('');
            $table->string('firma_declaracion')->default('');

            $table->string('profile_photo_url')->nullable()->default('/assets/admin-lte/dist/img/default-150x150.png');

            $table->softDeletes($column = 'deleted_at', $precision = 0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};

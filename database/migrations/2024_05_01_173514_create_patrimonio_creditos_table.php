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
        Schema::create('patrimonio_creditos', function (Blueprint $table) {
            $table->id();

            $table->integer('clientes_id');

            $table->string('descripcion_bien')->default('');
            $table->string('ciudad_bien')->default('');
            $table->string('hipoteca_bien')->default('');
            $table->string('avaluo_comercial_bien')->default('');
            $table->string('avaluo_catastral_bien')->default('');
            $table->string('cedula_catastral_bien')->default('');
            $table->string('matricula_bien')->default('');
            $table->string('escritura_bien')->default('');
            $table->string('notaria_bien')->default('');
            $table->string('fecha_bien')->default('');
            $table->string('ciudad_parimonio_bien')->default('');

            $table->string('descripcion_bien_dos')->default('');
            $table->string('ciudad_bien_dos')->default('');
            $table->string('hipoteca_bien_dos')->default('');
            $table->string('avaluo_comercial_bien_dos')->default('');
            $table->string('avaluo_catastral_bien_dos')->default('');
            $table->string('cedula_catastral_bien_dos')->default('');
            $table->string('matricula_bien_dos')->default('');
            $table->string('escritura_bien_dos')->default('');
            $table->string('notaria_bien_dos')->default('');
            $table->string('fecha_bien_dos')->default('');
            $table->string('ciudad_parimonio_bien_dos')->default('');

            $table->string('descripcion_bien_tres')->default('');
            $table->string('ciudad_bien_tres')->default('');
            $table->string('hipoteca_bien_tres')->default('');
            $table->string('avaluo_comercial_bien_tres')->default('');
            $table->string('avaluo_catastral_bien_tres')->default('');
            $table->string('cedula_catastral_bien_tres')->default('');
            $table->string('matricula_bien_tres')->default('');
            $table->string('escritura_bien_tres')->default('');
            $table->string('notaria_bien_tres')->default('');
            $table->string('fecha_bien_tres')->default('');
            $table->string('ciudad_parimonio_bien_tres')->default('');

            $table->string('marca_vehiculo')->default('');
            $table->string('clase_vehiculo')->default('');
            $table->string('modelo_vehiculo')->default('');
            $table->string('placa_vehiculo')->default('');
            $table->string('valor_vehiculo')->default('');
            $table->string('hipoteca_vehiculo')->default('');

            $table->string('marca_vehiculo_dos')->default('');
            $table->string('clase_vehiculo_dos')->default('');
            $table->string('modelo_vehiculo_dos')->default('');
            $table->string('placa_vehiculo_dos')->default('');
            $table->string('valor_vehiculo_dos')->default('');
            $table->string('hipoteca_vehiculo_dos')->default('');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patrimonio_creditos');
    }
};

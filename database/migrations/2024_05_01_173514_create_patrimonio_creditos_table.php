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

            $table->integer('sol_servicios_id');

            $table->string('descripcion_bien')->nullable();
            $table->string('ciudad_bien')->nullable();
            $table->string('hipoteca_bien')->nullable();
            $table->string('avaluo_comercial_bien')->nullable();
            $table->string('avaluo_catastral_bien')->nullable();
            $table->string('cedula_catastral_bien')->nullable();
            $table->string('matricula_bien')->nullable();
            $table->string('escritura_bien')->nullable();
            $table->string('notaria_bien')->nullable();
            $table->string('fecha_bien')->nullable();
            $table->string('ciudad_parimonio_bien')->nullable();

            $table->string('descripcion_bien_dos')->nullable();
            $table->string('ciudad_bien_dos')->nullable();
            $table->string('hipoteca_bien_dos')->nullable();
            $table->string('avaluo_comercial_bien_dos')->nullable();
            $table->string('avaluo_catastral_bien_dos')->nullable();
            $table->string('cedula_catastral_bien_dos')->nullable();
            $table->string('matricula_bien_dos')->nullable();
            $table->string('escritura_bien_dos')->nullable();
            $table->string('notaria_bien_dos')->nullable();
            $table->string('fecha_bien_dos')->nullable();
            $table->string('ciudad_parimonio_bien_dos')->nullable();

            $table->string('descripcion_bien_tres')->nullable();
            $table->string('ciudad_bien_tres')->nullable();
            $table->string('hipoteca_bien_tres')->nullable();
            $table->string('avaluo_comercial_bien_tres')->nullable();
            $table->string('avaluo_catastral_bien_tres')->nullable();
            $table->string('cedula_catastral_bien_tres')->nullable();
            $table->string('matricula_bien_tres')->nullable();
            $table->string('escritura_bien_tres')->nullable();
            $table->string('notaria_bien_tres')->nullable();
            $table->string('fecha_bien_tres')->nullable();
            $table->string('ciudad_parimonio_bien_tres')->nullable();

            $table->string('marca_vehiculo')->nullable();
            $table->string('clase_vehiculo')->nullable();
            $table->string('modelo_vehiculo')->nullable();
            $table->string('placa_vehiculo')->nullable();
            $table->string('valor_vehiculo')->nullable();
            $table->string('hipoteca_vehiculo')->nullable();

            $table->string('marca_vehiculo_dos')->nullable();
            $table->string('clase_vehiculo_dos')->nullable();
            $table->string('modelo_vehiculo_dos')->nullable();
            $table->string('placa_vehiculo_dos')->nullable();
            $table->string('valor_vehiculo_dos')->nullable();
            $table->string('hipoteca_vehiculo_dos')->nullable();

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

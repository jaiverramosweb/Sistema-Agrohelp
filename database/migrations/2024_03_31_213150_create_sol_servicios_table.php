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
        Schema::create('sol_servicios', function (Blueprint $table) {
            $table->id();

            $table->integer('clientes_id');
            $table->integer('direccion_id');
            $table->integer('producto_id');
            $table->integer('garantia_id');

            $table->string('numero');
            $table->string('valor');
            $table->string('tiempo_financiacion');
            $table->string('tasa_interes');
            $table->string('tasa_mora');
            $table->string('ciudad_solicitud');
            $table->string('tipo_cliente');
            $table->string('tipo_declarante');
            $table->string('profesion');
            $table->string('empresa_donde_labora');
            $table->string('indicador');
            $table->string('nombre_negocio');
            $table->string('nombre_conyuge');
            $table->string('empresa_conyuge');
            $table->string('indicador_autorizacion');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sol_servicios');
    }
};

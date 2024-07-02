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
        Schema::create('factura_pagos', function (Blueprint $table) {
            $table->id();
            $table->integer('pago');
            $table->string('fecha_pagar');
            $table->text('descripcion_pago')->nullable();
            $table->integer('sol_servicios_id')->nullable();
            $table->string('tipo')->nullable();
            $table->integer('metodo_pago_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factura_pagos');
    }
};

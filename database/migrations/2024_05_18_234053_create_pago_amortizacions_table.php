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
        Schema::create('pago_amortizacions', function (Blueprint $table) {
            $table->id();
            $table->integer('amortizations_id');
            $table->integer('factura_pagos_id');
            $table->integer('metodo_pago_id');
            $table->text('descripcion_pago')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pago_amortizacions');
    }
};

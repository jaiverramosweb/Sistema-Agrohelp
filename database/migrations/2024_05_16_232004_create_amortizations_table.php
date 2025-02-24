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
        Schema::create('amortizations', function (Blueprint $table) {
            $table->id();
            $table->integer('sol_servicios_id');
            $table->string('fecha');
            $table->integer('cuota_numero');
            $table->float('cuota', 15, 2);
            $table->float('interes', 15, 2);
            $table->float('interes2', 15, 2);
            $table->float('interes_pagado', 15, 2)->nullable();
            $table->float('amortizacion', 15, 2);
            $table->float('amortizacion2', 15, 2);
            $table->float('amortizacion_pagado', 15, 2)->nullable();
            $table->float('saldo_pendiente', 15, 2);
            $table->float('tasa', 15, 2);
            $table->float('mora', 15, 2);
            $table->float('mora_pagado', 15, 2)->nullable();
            $table->float('monto_solicitado', 15, 2);
            $table->string('tiempo_pagar');
            $table->boolean('estado')->default(false);
            $table->string('url_pago')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amortizations');
    }
};

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
        Schema::create('ingreso_egreso_creditos', function (Blueprint $table) {
            $table->id();

            $table->integer('sol_servicios_id');

            $table->string('salario')->nullable();
            $table->string('honorarios')->nullable();
            $table->string('otros_ingresos')->nullable();
            $table->string('otros_ingresos_describe')->nullable();
            $table->string('total_ingresos')->nullable();

            $table->string('alquiler')->nullable();
            $table->string('amortizacion')->nullable();
            $table->string('amortizacion_hipoteca')->nullable();
            $table->string('pago_tarjetas')->nullable();
            $table->string('otros_gastos')->nullable();
            $table->string('total_egresos')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingreso_egreso_creditos');
    }
};

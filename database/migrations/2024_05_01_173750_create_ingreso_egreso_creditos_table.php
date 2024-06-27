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

            $table->integer('clientes_id');

            $table->string('salario')->default('');
            $table->string('honorarios')->default('');
            $table->string('otros_ingresos')->default('');
            $table->string('otros_ingresos_describe')->default('');
            $table->string('total_ingresos')->default('');

            $table->string('alquiler')->default('');
            $table->string('amortizacion')->default('');
            $table->string('amortizacion_hipoteca')->default('');
            $table->string('pago_tarjetas')->default('');
            $table->string('otros_gastos')->default('');
            $table->string('total_egresos')->default('');

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

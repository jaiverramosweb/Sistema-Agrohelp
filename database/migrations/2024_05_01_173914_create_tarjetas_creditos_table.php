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
        Schema::create('tarjetas_creditos', function (Blueprint $table) {
            $table->id();

            $table->integer('sol_servicios_id');

            $table->string('acreedor')->nullable();
            $table->string('acreedor_dos')->nullable();
            $table->string('acreedor_telefono')->nullable();
            $table->string('acreedor_telefono_dos')->nullable();
            $table->string('acreedor_valor')->nullable();
            $table->string('acreedor_valor_dos')->nullable();
            $table->string('acreedor_saldo')->nullable();
            $table->string('acreedor_saldo_dos')->nullable();

            $table->string('banco_tarjeta')->nullable();
            $table->string('banco_tarjeta_dos')->nullable();
            $table->string('banco_antoguedad')->nullable();
            $table->string('banco_antoguedad_dos')->nullable();
            $table->string('banco_numero_antoguedad')->nullable();
            $table->string('banco_numero_antoguedad_dos')->nullable();
            $table->string('banco_cupo')->nullable();
            $table->string('banco_cupo_dos')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarjetas_creditos');
    }
};

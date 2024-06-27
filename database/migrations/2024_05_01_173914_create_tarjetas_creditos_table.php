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

            $table->integer('clientes_id');

            $table->string('acreedor')->default('');
            $table->string('acreedor_dos')->default('');
            $table->string('acreedor_telefono')->default('');
            $table->string('acreedor_telefono_dos')->default('');
            $table->string('acreedor_valor')->default('');
            $table->string('acreedor_valor_dos')->default('');
            $table->string('acreedor_saldo')->default('');
            $table->string('acreedor_saldo_dos')->default('');

            $table->string('banco_tarjeta')->default('');
            $table->string('banco_tarjeta_dos')->default('');
            $table->string('banco_antoguedad')->default('');
            $table->string('banco_antoguedad_dos')->default('');
            $table->string('banco_numero_antoguedad')->default('');
            $table->string('banco_numero_antoguedad_dos')->default('');
            $table->string('banco_cupo')->default('');
            $table->string('banco_cupo_dos')->default('');

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

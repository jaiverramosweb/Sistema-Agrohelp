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
        Schema::create('caracteristicas_productos', function (Blueprint $table) {
            $table->id();

            $table->integer('productos_id');

            $table->string('nombre');
            $table->string('interes');
            $table->string('mora')->nullable();
            $table->string('indicador')->nullable();
            $table->string('codigo')->nullable();
            $table->string('monto_minimo')->nullable();
            $table->string('monto_maximo')->nullable();
            $table->integer('tiempo_minimo')->nullable();
            $table->integer('tiempo_maximo')->nullable();
            $table->date('inactivacion')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caracteristicas_productos');
    }
};

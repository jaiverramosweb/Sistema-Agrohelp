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
            $table->string('mora');
            $table->string('indicador');
            $table->string('codigo');
            $table->integer('tiempo_minimo');
            $table->integer('tiempo_maximo');
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

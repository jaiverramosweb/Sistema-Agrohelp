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
        Schema::create('referencia_creditos', function (Blueprint $table) {
            $table->id();

            $table->integer('sol_servicios_id');

            $table->string('banco')->nullable();
            $table->string('sucursal')->nullable();
            $table->string('banco_numero')->nullable();
            $table->string('banco_dos')->nullable();
            $table->string('sucursal_dos')->nullable();
            $table->string('banco_numero_dos')->nullable();


            $table->string('nombre_comercal')->nullable();
            $table->string('direccion_comercal')->nullable();
            $table->string('telefono_comercal')->nullable();
            $table->string('nombre_comercal_dos')->nullable();
            $table->string('direccion_comercal_dos')->nullable();
            $table->string('telefono_comercal_dos')->nullable();

            $table->string('nombre_familiar')->nullable();
            $table->string('direccion_familiar')->nullable();
            $table->string('telefono_familiar')->nullable();
            $table->string('nombre_familiar_dos')->nullable();
            $table->string('direccion_familiar_dos')->nullable();
            $table->string('telefono_familiar_dos')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referencia_creditos');
    }
};

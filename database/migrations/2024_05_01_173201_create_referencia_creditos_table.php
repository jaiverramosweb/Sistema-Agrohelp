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

            $table->string('banco')->default('');
            $table->string('sucursal')->default('');
            $table->string('banco_numero')->default('');
            $table->string('banco_dos')->default('');
            $table->string('sucursal_dos')->default('');
            $table->string('banco_numero_dos')->default('');


            $table->string('nombre_comercal')->default('');
            $table->string('direccion_comercal')->default('');
            $table->string('telefono_comercal')->default('');
            $table->string('nombre_comercal_dos')->default('');
            $table->string('direccion_comercal_dos')->default('');
            $table->string('telefono_comercal_dos')->default('');

            $table->string('nombre_familiar')->default('');
            $table->string('direccion_familiar')->default('');
            $table->string('telefono_familiar')->default('');
            $table->string('nombre_familiar_dos')->default('');
            $table->string('direccion_familiar_dos')->default('');
            $table->string('telefono_familiar_dos')->default('');
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

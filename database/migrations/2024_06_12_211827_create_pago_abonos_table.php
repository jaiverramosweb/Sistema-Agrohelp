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
        Schema::create('pago_abonos', function (Blueprint $table) {
            $table->id();
            $table->integer('sol_servicios_id');
            $table->string('tipo');
            $table->string('monto');
            $table->integer('metodo_pago_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pago_abonos');
    }
};

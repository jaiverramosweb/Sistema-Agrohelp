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
        Schema::create('linea_creditos', function (Blueprint $table) {
            $table->id();

            $table->integer('sol_servicios_id');

            $table->string('tipo_credito')->nullable();
            $table->string('oficina_credito')->nullable();
            $table->string('vendedor_credito')->nullable();
            $table->string('monto_solicitado_credito')->nullable();
            $table->string('forma_pago_credito')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('linea_creditos');
    }
};

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
        Schema::table('sol_servicios', function (Blueprint $table) {
            $table->string('direccion_pers')->nullable();
            $table->string('telefono')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sol_servicios', function (Blueprint $table) {
            $table->dropColumn('direccion_pers');
            $table->dropColumn('telefono');
        });
    }
};

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
        Schema::table('factura_pagos', function (Blueprint $table) {
            $table->integer('banco_id')->nullable();
            $table->integer('retencion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('factura_pagos', function (Blueprint $table) {
            $table->dropColumn('banco_id');
            $table->dropColumn('retencion');
        });
    }
};

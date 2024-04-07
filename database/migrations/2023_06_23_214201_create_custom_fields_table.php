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
        Schema::create('custom_fields', function (Blueprint $table) {
            $table->id();

            $table->string('type_field')->default('')->nullable();
            $table->integer('fk_form_id')->default(0)->nullable();

            $table->integer('jerarquia')->default(0)->nullable();
            $table->string('id_input')->default('')->nullable();// Id dom elemento
            $table->string('name')->default('')->nullable();// Name dom elemento
            $table->string('title')->default('')->nullable();// Label para el input
            $table->string('type')->default('')->nullable();// Tipo de input
            $table->string('class')->default('')->nullable();// Class dom elemento
            $table->string('icon')->default('')->nullable();// Icon <I> tag
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_fields');
    }
};

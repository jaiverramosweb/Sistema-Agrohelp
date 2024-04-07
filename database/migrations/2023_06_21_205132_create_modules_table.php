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
        Schema::create('modules', function (Blueprint $table) {
            $table->id();

            $table->boolean('group')->default(false); // grupo al que terpetecev-if=" item.module_group == '0' "
            $table->integer('jerarquia');
            $table->string('module_permissions');
            $table->string('module_group')->default(''); // grupo al que terpetecev-if=" item.module_group == '0' "
            
            $table->string('name')->nullable();
            $table->string('icon')->nullable();
            $table->string('route')->nullable();// '' = modulo grupo
            
            $table->boolean('active')->nullable()->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};

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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            $table->integer('users_id')->nullable();
            $table->string('nombre')->nullable();
            $table->string('apellido')->nullable();
            $table->string('segundo_nombre')->nullable();
            $table->string('segundo_apellido')->nullable();
            $table->string('tipo_documento')->nullable();
            $table->string('documento')->nullable();
            $table->string('email')->unique();
            $table->string('genero')->nullable();
            $table->string('tipo_persona')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('estado_persona')->nullable();
            $table->string('indicador_persona')->nullable();
            $table->integer('role_id')->nullable();

            $table->string('profile_photo_url')->nullable()->default('/assets/admin-lte/dist/img/default-150x150.png');

            $table->softDeletes($column = 'deleted_at', $precision = 0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};

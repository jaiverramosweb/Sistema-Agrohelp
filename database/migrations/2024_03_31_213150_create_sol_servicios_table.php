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
        Schema::create('sol_servicios', function (Blueprint $table) {
            $table->id();

            $table->integer('clientes_id');
            $table->integer('producto_id');

            $table->string('monto')->nullable();
            $table->string('tiempo')->nullable();

            $table->string('numero')->nullable();
            $table->string('valor')->nullable();
            $table->string('tiempo_financiacion')->nullable();
            $table->string('tasa_interes')->nullable();
            $table->string('tasa_mora')->nullable();


            $table->string('ciudad_solicitud')->nullable();
            $table->string('tipo_cliente')->nullable();
            $table->string('tipo_declarante')->nullable();
            $table->string('profesion')->nullable();
            $table->string('empresa_donde_labora')->nullable();
            $table->string('indicador')->nullable();
            $table->string('nombre_negocio')->nullable();
            $table->string('nombre_conyuge')->nullable();
            $table->string('empresa_conyuge')->nullable();
            $table->string('indicador_autorizacion')->nullable();
            $table->string('domicilio')->nullable();
            $table->string('direccion_comercial')->nullable();
            $table->string('telefono_comercial')->nullable();
            $table->string('direccion_judicial')->nullable();
            $table->string('telefono_judicial')->nullable();
            $table->string('representante')->nullable();
            $table->string('representante_doc')->nullable();
            $table->string('autorretenedor')->nullable();
            $table->string('persona_pago')->nullable();
            $table->string('direccion_pago')->nullable();
            $table->string('telefono_pago')->nullable();
            $table->string('dia_pago')->nullable();
            $table->string('hora_pago')->nullable();
            $table->string('comentatio_pago')->nullable();
            $table->string('estado_civil')->nullable();
            $table->string('direccion_recidencia')->nullable();
            $table->string('telefono_recidencia')->nullable();
            $table->string('ciudad_recidencia')->nullable();
            $table->string('empresa')->nullable();
            $table->string('empresa_direccion')->nullable();
            $table->string('empresa_telefono')->nullable();
            $table->string('cargo_actual')->nullable();
            $table->string('antoguedad_empresa')->nullable();
            $table->string('personas_cargo')->nullable();
            $table->string('vivienda')->nullable();
            $table->string('independiente')->nullable();
            $table->string('camara_comercio')->nullable();
            $table->string('ocupacion_conyuge')->nullable();

            $table->string('firma_solicitud')->nullable();
            $table->string('firma_declaracion')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sol_servicios');
    }
};

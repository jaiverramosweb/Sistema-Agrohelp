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
            $table->integer('asesor_id')->nullable();
            $table->integer('producto_id')->nullable();
            $table->integer('linea_id')->nullable();

            $table->string('monto')->default('');
            $table->string('tiempo')->default('');

            $table->string('numero')->default('');
            $table->float('valor', 15, 2)->nullable();
            $table->integer('valor_activo')->nullable();
            $table->integer('canon_extraordinario')->nullable();
            $table->string('tiempo_financiacion')->default('');
            $table->string('tasa_interes')->default('');
            $table->string('tipo_interes')->default('');
            $table->float('interes_mas', 15, 2)->nullable();
            $table->string('tasa_mora')->default('');
            $table->string('cobro_intereses')->default('');


            $table->string('ciudad_solicitud')->default('');
            $table->string('tipo_cliente')->default('');
            $table->string('tipo_declarante')->default('');
            $table->string('profesion')->default('');
            $table->string('empresa_donde_labora')->default('');
            $table->string('indicador')->default('');
            $table->string('nombre_negocio')->default('');
            $table->string('nombre_conyuge')->default('');
            $table->string('empresa_conyuge')->default('');
            $table->string('indicador_autorizacion')->default('');
            $table->string('domicilio')->default('');
            $table->string('direccion_comercial')->default('');
            $table->string('telefono_comercial')->default('');
            $table->string('direccion_judicial')->default('');
            $table->string('telefono_judicial')->default('');
            $table->string('representante')->default('');
            $table->string('representante_doc')->default('');
            $table->string('autorretenedor')->default('');
            $table->string('persona_pago')->default('');
            $table->string('direccion_pago')->default('');
            $table->string('telefono_pago')->default('');
            $table->string('dia_pago')->default('');
            $table->string('hora_pago')->default('');
            $table->string('comentatio_pago')->default('');
            $table->string('estado_civil')->default('');
            $table->string('direccion_recidencia')->default('');
            $table->string('telefono_recidencia')->default('');
            $table->string('ciudad_recidencia')->default('');
            $table->string('empresa')->default('');
            $table->string('empresa_direccion')->default('');
            $table->string('empresa_telefono')->default('');
            $table->string('cargo_actual')->default('');
            $table->string('antoguedad_empresa')->default('');
            $table->string('personas_cargo')->default('');
            $table->string('vivienda')->default('');
            $table->string('independiente')->default('');
            $table->string('camara_comercio')->default('');
            $table->string('ocupacion_conyuge')->default('');

            // $table->string('firma_solicitud')->default('');
            // $table->string('firma_declaracion')->default('');

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

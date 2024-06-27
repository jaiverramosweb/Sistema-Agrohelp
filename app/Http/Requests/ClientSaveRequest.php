<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email'                     => ['nullable'],
            'id_user_sap'               => ['nullable'],
            'id_prove_sap'              => ['nullable'],
            'password'                  => ['nullable'],
            'nombre'                    => ['required', 'string'],
            'segundo_nombre'            => ['nullable'],
            'apellido'                  => ['nullable'],
            'segundo_apellido'          => ['nullable'],
            'tipo_documento'            => ['required'],
            'documento'                 => ['nullable'],
            'email'                     => ['nullable'],
            'genero'                    => ['nullable'],
            'tipo_persona'              => ['nullable'],
            'fecha_nacimiento'          => ['nullable'],
            'direcciones'               => ['nullable'],

            'ciudad_solicitud'          => ['nullable'],
            'tipo_cliente'              => ['nullable'],
            'tipo_declarante'           => ['nullable'],
            'profesion'                 => ['nullable'],
            'empresa_donde_labora'      => ['nullable'],
            'indicador'                 => ['nullable'],
            'nombre_negocio'            => ['nullable'],
            'nombre_conyuge'            => ['nullable'],
            'empresa_conyuge'           => ['nullable'],
            'indicador_autorizacion'    => ['nullable'],
            'domicilio'                 => ['nullable'],
            'direccion_comercial'       => ['nullable'],
            'telefono_comercial'        => ['nullable'],
            'direccion_judicial'        => ['nullable'],
            'telefono_judicial'         => ['nullable'],
            'representante'             => ['nullable'],
            'representante_doc'         => ['nullable'],
            'autorretenedor'            => ['nullable'],
            'persona_pago'              => ['nullable'],
            'direccion_pago'            => ['nullable'],
            'telefono_pago'             => ['nullable'],
            'dia_pago'                  => ['nullable'],
            'hora_pago'                 => ['nullable'],
            'comentatio_pago'           => ['nullable'],
            'estado_civil'              => ['nullable'],
            'direccion_recidencia'      => ['nullable'],
            'telefono_recidencia'       => ['nullable'],
            'ciudad_recidencia'         => ['nullable'],
            'empresa'                   => ['nullable'],
            'empresa_direccion'         => ['nullable'],
            'empresa_telefono'          => ['nullable'],
            'cargo_actual'              => ['nullable'],
            'antoguedad_empresa'        => ['nullable'],
            'personas_cargo'            => ['nullable'],
            'vivienda'                  => ['nullable'],
            'independiente'             => ['nullable'],
            'camara_comercio'           => ['nullable'],
            'ocupacion_conyuge'         => ['nullable'],
        ];
    }
}

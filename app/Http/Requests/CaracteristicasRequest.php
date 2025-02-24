<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaracteristicasRequest extends FormRequest
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
            'productos_id'          => ['required'],
            'nombre'                => ['required'],
            'interes'               => ['nullable'],
            'mora'                  => ['nullable'],
            'indicador'             => ['nullable'],
            'codigo'                => ['nullable'],
            'monto_minimo'          => ['nullable'],
            'monto_maximo'          => ['nullable'],
            'tiempo_minimo'         => ['nullable'],
            'tiempo_maximo'         => ['nullable'],
            'tipo_amortizacion'     => ['nullable'],
            'terminos_condiciones'  => ['nullable'],
            'cobro_intereses'       => ['nullable'],
            'periodicidad'          => ['nullable'],
            'garantias'             => ['nullable'],
            'documentos'            => ['nullable']

        ];
    }
}

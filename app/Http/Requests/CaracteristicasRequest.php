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
            'productos_id'  => ['required'],
            'nombre'        => ['required'],
            'interes'       => ['required'],
            'mora'          => ['required'],
            'indicador'     => ['nullable'],
            'codigo'        => ['required'],
            'monto_minimo'  => ['required'],
            'monto_maximo'  => ['required'],
            'tiempo_minimo' => ['required'],
            'tiempo_maximo' => ['required'],
            'garantias'     => ['nullable'],
            'documentos'    => ['nullable']

        ];
    }
}

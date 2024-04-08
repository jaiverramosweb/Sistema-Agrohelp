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
            'direcciones'               => ['nullable']
        ];
    }
}

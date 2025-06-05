<?php

namespace App\Interfaces\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmpresaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'sometimes|string|max:255',
            'direccion' => 'sometimes|string|max:255',
            'telefono' => ['sometimes', 'string', 'max:20', 'regex:/^[0-9\s\-\+]+$/'],
            'estado' => 'sometimes|in:activo,inactivo',
        ];
    }

    public function messages(): array
    {
        return [
            'telefono.regex' => 'El teléfono tiene un formato inválido.',
            'estado.in' => 'El estado debe ser activo o inactivo.',
        ];
    }
}

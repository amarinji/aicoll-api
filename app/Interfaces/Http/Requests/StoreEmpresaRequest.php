<?php

namespace App\Interfaces\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmpresaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nit' => 'required|string|unique:empresas,nit',
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => ['required', 'string', 'max:20', 'regex:/^[0-9\s\-\+]+$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'nit.required' => 'El NIT es obligatorio.',
            'nit.unique' => 'Este NIT ya está registrado.',
            'telefono.regex' => 'El teléfono tiene un formato inválido.',
        ];
    }
}

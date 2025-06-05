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
            'telefono' => 'required|string|max:20|regex:/^[\d\s\-\+\(\)]+$/'
        ];
    }

    public function messages(): array
    {
      return [
            'nit.unique' => 'Ya existe una empresa registrada con este NIT.',
            'telefono.regex' => 'El teléfono solo puede contener números, espacios, paréntesis, guiones o signos +.',
        ];
    }
}

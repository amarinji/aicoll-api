<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;	
use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Http\Requests\StoreEmpresaRequest;
use App\Http\Requests\UpdateEmpresaRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class EmpresaController extends Controller
{
    // Crear nueva empresa

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nit' => 'required|string|unique:empresas,nit',
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $empresa = Empresa::create($request->all());

        return response()->json([
            'message' => 'Empresa creada con éxito',
            'empresa' => $empresa
        ], 201);
    }


    // Listar todas las empresas
    public function index(): JsonResponse
    {
        $empresas = Empresa::all();

        return response()->json($empresas);
    }

    // Mostrar empresa por NIT
    public function show(string $nit): JsonResponse
    {
        $empresa = Empresa::find($nit);

        if (!$empresa) {
            return response()->json(['message' => 'Empresa no encontrada'], 404);
        }

        return response()->json($empresa);
    }

    // Actualizar empresa
    public function update(UpdateEmpresaRequest $request, string $nit): JsonResponse
    {
        $empresa = Empresa::find($nit);

        if (!$empresa) {
            return response()->json(['message' => 'Empresa no encontrada'], 404);
        }

        $empresa->update($request->validated());

        return response()->json(['message' => 'Empresa actualizada correctamente', 'empresa' => $empresa]);
    }

    // Eliminar empresas con estado inactivo
    public function destroyInactivas(): JsonResponse
    {
        $eliminadas = Empresa::where('estado', 'inactivo')->delete();

        return response()->json(['message' => "Se eliminaron $eliminadas empresas inactivas."]);
    }
}


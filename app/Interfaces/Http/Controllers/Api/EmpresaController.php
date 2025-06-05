<?php

namespace App\Interfaces\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Interfaces\Http\Controllers\Controller;
use App\Interfaces\Http\Requests\StoreEmpresaRequest;
use App\Interfaces\Http\Requests\UpdateEmpresaRequest;
use App\Application\DTOs\EmpresaDTO;
use App\Application\UseCases\EmpresaService;
use App\Application\UseCases\CrearEmpresaService;
use App\Exceptions\EmpresaNoEncontradaException;
use InvalidArgumentException;

class EmpresaController extends Controller
{
    protected EmpresaService $empresaService;
    protected CrearEmpresaService $crearEmpresaService;

    public function __construct(
        EmpresaService $empresaService,
        CrearEmpresaService $crearEmpresaService
    ) {
        $this->empresaService = $empresaService;
        $this->crearEmpresaService = $crearEmpresaService;
    }

    public function store(StoreEmpresaRequest $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string',
                'nit' => 'required|unique:empresas,nit',
                'direccion' => 'nullable|string',
                'telefono' => 'nullable|string',
            ]);

            $empresa = $service->handle($validated);

            return response()->json([
                'message' => 'Empresa creada con éxito',
                'empresa' => [
                    'id' => $empresa->id,
                    'nombre' => $empresa->nombre,
                    'nit' => $empresa->nit,
                    'created_at' => $empresa->created_at,
                    'updated_at' => $empresa->updated_at,
                ]
            ], 201);
        } catch (InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function index(): JsonResponse
    {
        $empresas = $this->empresaService->obtenerTodas();
        return response()->json([
            'message' => 'Listado de empresas',
            'data' => $empresas
        ]);
    }

    public function show(string $nit): JsonResponse
    {
        try {
            $empresa = $this->empresaService->obtenerPorNit($nit);
            return response()->json([
                'message' => 'Empresa encontrada',
                'empresa' => $empresa
            ]);
        } catch (EmpresaNoEncontradaException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function update(UpdateEmpresaRequest $request, string $nit): JsonResponse
    {
        try {
            $empresaDTO = new EmpresaDTO($request->validated());
            $empresaActualizada = $this->empresaService->actualizarEmpresa($nit, $empresaDTO);
            return response()->json([
                'message' => 'Empresa actualizada con éxito',
                'empresa' => $empresaActualizada
            ]);
        } catch (EmpresaNoEncontradaException | InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function destroyInactivas(): JsonResponse
    {
        $eliminadas = $this->empresaService->eliminarInactivas();
        return response()->json(['message' => "Se eliminaron $eliminadas empresas inactivas."]);
    }
}

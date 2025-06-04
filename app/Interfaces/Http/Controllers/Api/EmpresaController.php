<?php

namespace App\Interfaces\Http\Controllers\Api;

use App\Interfaces\Http\Controllers\Controller;	
use App\Application\UseCases\EmpresaService;
use App\Application\UseCases\CrearEmpresaService;
use Illuminate\Http\Request;
use App\Interfaces\Http\Requests\StoreEmpresaRequest;
use App\Interfaces\Http\Requests\UpdateEmpresaRequest;
use Illuminate\Http\JsonResponse;
use App\Application\DTOs\EmpresaDTO;
use InvalidArgumentException;

class EmpresaController extends Controller
{
    // protected EmpresaService $empresaService;
    protected CrearEmpresaService $crearEmpresaService;

    public function __construct(CrearEmpresaService $crearEmpresaService)
    {
        $this->crearEmpresaService = $crearEmpresaService;
    }

    
    public function store(StoreEmpresaRequest $request): JsonResponse
    {
        try {
            $empresaDTO = new EmpresaDTO($request->validated());
            $empresa = $this->crearEmpresaService->crearEmpresa($empresaDTO);
            return response()->json([
                'message' => 'Empresa creada con éxito',
                'empresa' => $empresa
            ], 201);
        } catch (InvalidArgumentException $e) {
        return response()->json([
            'message' => $e->getMessage()
        ], 422);
    }
    }

    public function index(): JsonResponse
    {
        $empresas = $this->empresaService->obtenerTodas();

        return response()->json($empresas);
    }

    public function show(string $nit): JsonResponse
    {
        $empresa = $this->empresaService->obtenerPorNit($nit);
        return response()->json($empresa);
    }

    public function update(UpdateEmpresaRequest $request, string $nit): JsonResponse
    {
        $empresaDTO = new EmpresaDTO($request->validated());

        $empresaActualizada = $this->empresaService->actualizarEmpresa($nit, $empresaDTO);

        return response()->json([
            'message' => 'Empresa actualizada con éxito',
            'empresa' => $empresaActualizada
        ]);
    }

    public function destroyInactivas(): JsonResponse
    {
        $eliminadas = $this->empresaService->eliminarInactivas();

        return response()->json(['message' => "Se eliminaron $eliminadas empresas inactivas."]);
    }
}

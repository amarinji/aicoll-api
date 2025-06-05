<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;	
// use App\Application\UseCases\EmpresaService;
use App\Application\UseCases\CrearEmpresaService;
use App\Application\UseCases\ActualizarEmpresaService;
use App\Application\UseCases\ObtenerPorNitService;
use App\Application\UseCases\ObtenerTodasService;
use App\Application\UseCases\EliminarInactivasService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEmpresaRequest;
use App\Http\Requests\UpdateEmpresaRequest;
use Illuminate\Http\JsonResponse;
use App\Application\DTOs\EmpresaDTO;
use InvalidArgumentException;

class EmpresaController extends Controller
{
    // protected EmpresaService $empresaService;
    protected CrearEmpresaService $crearEmpresaService;
    protected ActualizarEmpresaService $actualizarEmpresaService;
    protected ObtenerPorNitService $obtenerPorNitService;
    protected ObtenerTodasService $obtenerTodasService;
    protected EliminarInactivasService $eliminarInactivasService;

    public function __construct(
        CrearEmpresaService $crearEmpresaService,
        ActualizarEmpresaService $actualizarEmpresaService,
        ObtenerPorNitService $obtenerPorNitService,
        ObtenerTodasService $obtenerTodasService,
        EliminarInactivasService $eliminarInactivasService
    )
    {
        $this->crearEmpresaService = $crearEmpresaService;
        $this->actualizarEmpresaService = $actualizarEmpresaService;
        $this->obtenerPorNitService = $obtenerPorNitService;
        $this->obtenerTodasService = $obtenerTodasService;
        $this->eliminarInactivasService = $eliminarInactivasService;
    }

    
    public function store(StoreEmpresaRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $empresaDTO = new EmpresaDTO(
                $validated['nit'],
                $validated['nombre'],
                $validated['direccion'],
                $validated['telefono']
            );
            $empresa = $this->crearEmpresaService->handle($empresaDTO);
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
        $empresas = $this->obtenerTodasService->handle();

        return response()->json($empresas);
    }

    public function show(string $nit): JsonResponse
    {
         try {
            $empresa = $this->empresaRepository->obtenerPorNit($nit);
            return response()->json($empresa);
        } catch (EmpresaNoEncontradaException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function update(UpdateEmpresaRequest $request, string $nit): JsonResponse
    {
        $empresaDTO = new EmpresaDTO($request->validated());

        $empresaActualizada = $this->actualizarEmpresaService->handle($nit, $empresaDTO);

        return response()->json([
            'message' => 'Empresa actualizada con éxito',
            'empresa' => $empresaActualizada
        ]);
    }

    public function destroyInactivas(): JsonResponse
    {
        $eliminadas = $this->eliminarInactivasService->handle();

        return response()->json(['message' => "Se eliminaron $eliminadas empresas inactivas."]);
    }
}

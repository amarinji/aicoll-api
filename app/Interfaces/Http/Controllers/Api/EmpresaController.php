<?php

namespace App\Interfaces\Http\Controllers\Api;

use App\Interfaces\Http\Controllers\Controller;	
use App\Application\UseCases\CrearEmpresaUseCase;
use App\Application\UseCases\ActualizarEmpresaUseCase;
use App\Application\UseCases\ObtenerPorNitUseCase;
use App\Application\UseCases\ObtenerTodasUseCase;
use App\Application\UseCases\EliminarInactivasUseCase;
use App\Interfaces\Http\Requests\StoreEmpresaRequest;
use App\Interfaces\Http\Requests\UpdateEmpresaRequest;
use Illuminate\Http\JsonResponse;
use App\Application\DTOs\EmpresaDTO;
use App\Infrastructure\Persistence\Mappers\EmpresaMapper;
use InvalidArgumentException;

class EmpresaController extends Controller
{
    protected CrearEmpresaUseCase $crearEmpresaUseCase;
    protected ActualizarEmpresaUseCase $actualizarEmpresaUseCase;
    protected ObtenerPorNitUseCase $obtenerPorNitUseCase;
    protected ObtenerTodasUseCase $obtenerTodasUseCase;
    protected EliminarInactivasUseCase $eliminarInactivasUseCase;

    public function __construct(
        CrearEmpresaUseCase $crearEmpresaUseCase,
        ActualizarEmpresaUseCase $actualizarEmpresaUseCase,
        ObtenerPorNitUseCase $obtenerPorNitUseCase,
        ObtenerTodasUseCase $obtenerTodasUseCase,
        EliminarInactivasUseCase $eliminarInactivasUseCase
    )
    {
        $this->crearEmpresaUseCase = $crearEmpresaUseCase;
        $this->actualizarEmpresaUseCase = $actualizarEmpresaUseCase;
        $this->obtenerPorNitUseCase = $obtenerPorNitUseCase;
        $this->obtenerTodasUseCase = $obtenerTodasUseCase;
        $this->eliminarInactivasUseCase = $eliminarInactivasUseCase;
    }

    public function store(StoreEmpresaRequest $request): JsonResponse
    {        
        try {
            $validated = $request->validated();

            $empresaDTO = new EmpresaDTO(
                $validated['nit'],
                $validated['nombre'],
                $validated['direccion'] ?? null,
                $validated['telefono'] ?? null
            );

            $empresa = $this->crearEmpresaUseCase->execute($empresaDTO);

            return response()->json([
                'message' => 'Empresa creada con éxito',
                'empresa' => EmpresaMapper::toDTO($empresa)->toArray()
            ], 201);
        } catch (EmpresaYaExisteException $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        } catch (InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error inesperado. Intente nuevamente.',
                'error' => $e->getMessage()
            ], 500);               
        }
    }


    public function index(): JsonResponse
    {
        return response()->json(
            $this->obtenerTodasUseCase->execute()
                ->map(fn($empresa) => EmpresaMapper::toDTO($empresa)->toArray())
        );
    }

    public function show(string $nit): JsonResponse
    {
         try {
            $empresa = $this->obtenerPorNitUseCase->execute($nit);
            return response()->json(EmpresaMapper::toDTO($empresa)->toArray());
        } catch (EmpresaNoEncontradaException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function update(UpdateEmpresaRequest $request, string $nit): JsonResponse
    {
        $data = $request->validated();

       $empresaDTO = EmpresaDTO::createWithoutNit(
            nombre: $data['nombre'],
            direccion: $data['direccion'] ?? '',
            telefono: $data['telefono'] ?? '',
            estado: $data['estado'] ?? 'activo'
        );

        try {
            $empresaActualizada = $this->actualizarEmpresaUseCase->execute($nit, $empresaDTO);
            return response()->json([
                'message' => 'Empresa actualizada con éxito',
                'empresa' => EmpresaMapper::toDTO($empresaActualizada)->toArray()
            ], 200);
        } catch (EmpresaNoEncontradaException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }

    }

    public function destroyInactivas(): JsonResponse
    {
        $eliminadas = $this->eliminarInactivasUseCase->execute();

     return response()->json([
            'message' => "Se eliminaron $eliminadas empresas inactivas.",
            'eliminadas' => $eliminadas
        ]);
    }
}

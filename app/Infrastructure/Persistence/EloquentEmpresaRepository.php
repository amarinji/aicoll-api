<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Empresa;
use App\Domain\Repositories\EmpresaRepositoryInterface;
use App\Exceptions\EmpresaNoEncontradaException;
use App\Infrastructure\Persistence\Eloquent\Models\EmpresaModel;
use App\Infrastructure\Persistence\Eloquent\Mappers\EmpresaMapper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class EloquentEmpresaRepository implements EmpresaRepositoryInterface
{
    public function crear(Empresa $empresa): Empresa
    {
        $model = EmpresaMapper::toModel($empresa);
        $model->save();

        Log::info("Empresa creada: NIT {$empresa->nit}");

        return EmpresaMapper::toEntity($model);
    }

    public function obtenerTodas(): Collection
    {
        return EmpresaModel::all()
            ->map(fn(EmpresaModel $model) => EmpresaMapper::toEntity($model));
    }

    public function obtenerPorNit(string $nit): Empresa
    {
        $model = EmpresaModel::where('nit', $nit)->first();

        if (!$model) {
            throw new EmpresaNoEncontradaException($nit);
        }

        return EmpresaMapper::toEntity($model);
    }

    public function actualizar(Empresa $empresa): Empresa
    {
        $model = EmpresaModel::where('nit', $empresa->nit)->first();

        if (!$model) {
            throw new EmpresaNoEncontradaException($empresa->nit);
        }

        $model->fill([
            'nombre' => $empresa->nombre,
            'direccion' => $empresa->direccion,
            'telefono' => $empresa->telefono,
            'estado' => $empresa->estado,
        ]);

        $model->save();

        Log::info("Empresa actualizada: NIT {$empresa->nit}");

        return EmpresaMapper::toEntity($model);
    }

    public function eliminarInactivas(): int
    {
        return EmpresaModel::where('estado', 'inactivo')->delete();
    }
}

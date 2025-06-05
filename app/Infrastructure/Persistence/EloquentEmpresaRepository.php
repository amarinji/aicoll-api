<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Empresa;
use App\Domain\Repositories\EmpresaRepositoryInterface;
use App\Exceptions\EmpresaNoEncontradaException;
use App\Infrastructure\Persistence\Eloquent\EmpresaModel;
use App\Infrastructure\Persistence\Mappers\EmpresaMapper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class EloquentEmpresaRepository implements EmpresaRepositoryInterface
{
    public function crear(Empresa $empresa): Empresa
    {
        $model = EmpresaMapper::toModel($empresa);
        $model->save();

        Log::info("Empresa creada: NIT {$empresa->getNit()}");

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
        try {
            $model = EmpresaModel::where('nit', $empresa->getnit())->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new EmpresaNoEncontradaException($empresa->getNit());
        }

        $model = EmpresaMapper::updateModelFromEntity($model, $empresa);
        $model->save();

        return EmpresaMapper::toEntity($model);
    }


    public function eliminarInactivas(): int
    {
        $count = EmpresaModel::where('estado', 'inactivo')->delete();
        Log::info("Empresas inactivas eliminadas: {$count}");
        return $count;
    }
}

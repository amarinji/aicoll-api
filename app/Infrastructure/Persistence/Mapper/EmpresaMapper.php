<?php

use App\Domain\Entities\Empresa;
use App\Infrastructure\Persistence\Eloquent\EmpresaModel;

class EmpresaMapper
{
    public static function toModel(Empresa $empresa): EmpresaModel
    {
        return new EmpresaModel([
            'nit' => $empresa->nit,
            'nombre' => $empresa->nombre,
            'direccion' => $empresa->direccion,
            'telefono' => $empresa->telefono,
            'estado' => $empresa->estado,
        ]);
    }

    public static function toEntity(EmpresaModel $model): Empresa
    {
        return new Empresa(
            nit: $model->nit,
            nombre: $model->nombre,
            direccion: $model->direccion,
            telefono: $model->telefono,
            estado: $model->estado
        );
    }
}

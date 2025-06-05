<?php

namespace App\Infrastructure\Persistence\Mappers;

use App\Domain\Entities\Empresa;
use App\Application\DTOs\EmpresaDTO;
use App\Infrastructure\Persistence\Eloquent\EmpresaModel;

class EmpresaMapper
{
    public static function toModel(Empresa $empresa): EmpresaModel
    {
        return new EmpresaModel([
            'nit' => $empresa->getNit(),
            'nombre' => $empresa->getNombre(),
            'direccion' => $empresa->getDireccion(),
            'telefono' => $empresa->getTelefono(),
            'estado' => $empresa->getEstado(),
        ]);
    }

    public static function toEntity(EmpresaModel $model): Empresa
    {
        return new Empresa(
            $model->nit,
            $model->nombre,
            $model->direccion,
            $model->telefono,
            $model->estado
        );
    }

    public static function toDTO(Empresa $empresa): EmpresaDTO
    {
        return new EmpresaDTO(
            $empresa->getNit(),
            $empresa->getNombre(),
            $empresa->getDireccion(),
            $empresa->getTelefono(),
            $empresa->getEstado()
        );
    }

    public static function updateModelFromEntity(EmpresaModel $model, Empresa $empresa): EmpresaModel
    {
        $model->nit = $empresa->getNit();
        $model->nombre = $empresa->getNombre();
        $model->direccion = $empresa->getDireccion();
        $model->telefono = $empresa->getTelefono();
        $model->estado = $empresa->getEstado();

        return $model;
    }
}

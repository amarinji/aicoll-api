<?php

namespace App\Application\UseCases;

use App\Application\DTOs\EmpresaDTO;
use App\Domain\Entities\Empresa;
use App\Domain\Repositories\EmpresaRepositoryInterface;


class CrearEmpresaService
{
    public function __construct(
        private EmpresaRepositoryInterface $repository
    ) {}

    public function handle(EmpresaDTO $dto): Empresa
    {
        $empresa = new Empresa(
            nit: $dto->nit,
            nombre: $dto->nombre,
            direccion: $dto->direccion,
            telefono: $dto->telefono,
        );

        return $this->repository->crear($empresa);
    }
}
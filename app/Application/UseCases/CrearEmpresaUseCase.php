<?php

namespace App\Application\UseCases;

use App\Application\DTOs\EmpresaDTO;
use App\Domain\Entities\Empresa;
use App\Domain\Repositories\EmpresaRepositoryInterface;


class CrearEmpresaUseCase
{
    public function __construct(
        private EmpresaRepositoryInterface $repository
    ) {}

    public function execute(EmpresaDTO $dto): Empresa
    {
        $empresa = new Empresa($dto->getNit(), $dto->getNombre(), $dto->getDireccion(), $dto->getTelefono());
        return $this->repository->crear($empresa);
    }
}
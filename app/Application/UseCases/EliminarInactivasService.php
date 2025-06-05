<?php

namespace App\Application\UseCases;

use App\Application\DTOs\EmpresaDTO;
use App\Domain\Entities\Empresa;
use App\Domain\Repositories\EmpresaRepositoryInterface;


class EliminarInactivasService
{
    public function __construct(
        private EmpresaRepositoryInterface $repository
    ) {}

    public function handle(): int
    {
        return $this->repository->eliminarInactivas();
    }
}
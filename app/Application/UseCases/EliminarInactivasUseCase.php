<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\EmpresaRepositoryInterface;


class EliminarInactivasUseCase
{
    public function __construct(
        private EmpresaRepositoryInterface $repository
    ) {}

    public function execute(): int
    {
        return $this->repository->eliminarInactivas();
    }
}
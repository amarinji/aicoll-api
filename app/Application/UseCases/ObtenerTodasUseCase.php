<?php

namespace App\Application\UseCases;

use Illuminate\Support\Collection;
use App\Domain\Repositories\EmpresaRepositoryInterface;


class ObtenerTodasUseCase
{
    public function __construct(
        private EmpresaRepositoryInterface $repository
    ) {}

    public function execute(): Collection
    {
        return $this->repository->obtenerTodas();
    }
}
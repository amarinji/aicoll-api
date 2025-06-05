<?php

namespace App\Application\UseCases;

use Illuminate\Support\Collection;
use App\Application\DTOs\EmpresaDTO;
use App\Domain\Entities\Empresa;
use App\Domain\Repositories\EmpresaRepositoryInterface;


class ObtenerTodasService
{
    public function __construct(
        private EmpresaRepositoryInterface $repository
    ) {}

    public function handle(): Collection
    {
        return $this->repository->obtenerTodas();
    }
}
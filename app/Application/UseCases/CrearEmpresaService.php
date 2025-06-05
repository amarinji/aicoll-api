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

    public function handle(array $data): Empresa
    {
        $empresa = new Empresa(
            nit: $data['nit'],
            nombre: $data['nombre'],
            direccion: $data['direccion'] ?? null,
            telefono: $data['telefono'] ?? null,
        );

        return $this->repository->crear($empresa);
    }
}
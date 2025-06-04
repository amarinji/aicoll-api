<?php

namespace App\Application\UseCases;

use App\Application\DTOs\EmpresaDTO;
use App\Domain\Entities\Empresa;
use App\Domain\Repositories\EmpresaRepositoryInterface;

class CrearEmpresaService
{
    protected EmpresaRepositoryInterface $empresaRepository;

    public function __construct(EmpresaRepositoryInterface $empresaRepository)
    {
        $this->empresaRepository = $empresaRepository;
    }

    public function crearEmpresa(EmpresaDTO $empresaDTO): Empresa
    {
        return $this->empresaRepository->crear([
            'nit' => $empresaDTO->nit,
            'nombre' => $empresaDTO->nombre,
            'direccion' => $empresaDTO->getDireccion(),
            'telefono' => $empresaDTO->telefonoFormateado(),
        ]);
    }
}

<?php

namespace App\Application\UseCases;

use App\Application\DTOs\EmpresaDTO;
use App\Domain\Entities\Empresa;
use App\Domain\Repositories\EmpresaRepositoryInterface;
use App\Exceptions\EmpresaNoEncontradaException;

class ActualizarEmpresaUseCase
{
    public function __construct(
        private EmpresaRepositoryInterface $repository
    ) {}

    public function execute(string $nit, EmpresaDTO $empresaDTO): Empresa
    {
        $empresaExistente = $this->repository->obtenerPorNit($nit);
        
        if ($empresaExistente === null) {
            throw new EmpresaNoEncontradaException("Empresa con NIT $nit no encontrada.");
        }

        $empresaExistente->setNombre($empresaDTO->getNombre());
        $empresaExistente->setDireccion($empresaDTO->getDireccion());
        $empresaExistente->setTelefono($empresaDTO->getTelefono());
        $empresaExistente->setEstado($empresaDTO->getEstado());

        return $this->repository->actualizar($empresaExistente);
    }
}

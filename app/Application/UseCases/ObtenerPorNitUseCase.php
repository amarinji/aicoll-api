<?php

namespace App\Application\UseCases;

use App\Domain\Entities\Empresa;
use App\Domain\Repositories\EmpresaRepositoryInterface;


class ObtenerPorNitUseCase
{
    public function __construct(
        private EmpresaRepositoryInterface $repository
    ) {}
    
    public function execute(string $nit): Empresa
    {
        $empresaExistente = $this->repository->obtenerPorNit($nit);

        if ($empresaExistente === null) {
            throw new EmpresaNoEncontradaException("Empresa con NIT $nit no encontrada.");
        }

        return $empresaExistente; 
    }

}
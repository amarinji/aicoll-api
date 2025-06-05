<?php

namespace App\Application\UseCases;

use App\Application\DTOs\EmpresaDTO;
use App\Domain\Entities\Empresa;
use App\Domain\Repositories\EmpresaRepositoryInterface;


class ObtenerPorNitService
{
    public function __construct(
        private EmpresaRepositoryInterface $repository
    ) {}
    
    public function handle(string $nit): Empresa
    {
        return $this->repository->obtenerPorNit($nit); 
    }

}
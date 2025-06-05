<?php

namespace App\Application\UseCases;

use App\Application\DTOs\EmpresaDTO;
use App\Domain\Entities\Empresa;
use App\Domain\Repositories\EmpresaRepositoryInterface;


class ActualizarEmpresaService
{
    public function __construct(
        private EmpresaRepositoryInterface $repository
    ) {}

    public function handle(string $nit, EmpresaDTO $empresaDTO): Empresa
    {
        $empresa = $this->obtenerPorNit($nit);

        $empresa->update([
            'nombre' => $empresaDTO->nombre,
            'direccion' => $empresaDTO->direccion,
            'telefono' => $empresaDTO->telefono,
            'estado' => $empresaDTO->estado,
        ]);

        return $empresa;
    }
}
<?php

namespace App\Application\UseCases;

use Illuminate\Support\Collection;
use App\Domain\Entities\Empresa;
use App\Domain\Repositories\EmpresaRepositoryInterface;
use App\Application\DTOS\EmpresaDTO;
use App\Exceptions\EmpresaNoEncontradaException;

class EmpresaService
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

    public function obtenerTodas(): Collection
    {
        return $this->empresaRepository->obtenerTodas();
    }

    public function obtenerPorNit(string $nit): Empresa
    {
        return $this->empresaRepository->obtenerPorNit($nit);
    }


    public function actualizarEmpresa(string $nit, EmpresaDTO $empresaDTO): Empresa
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

    public function eliminarInactivas(): int
    {
        return $this->empresaRepository->eliminarInactivas();
    }
}

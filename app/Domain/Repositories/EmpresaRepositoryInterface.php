<?php

namespace App\Domain\Repositories;

use Illuminate\Support\Collection;
use App\Domain\Entities\Empresa;

interface EmpresaRepositoryInterface
{
    public function crear(Empresa $empresa): Empresa;

    public function obtenerTodas(): Collection;

    public function obtenerPorNit(string $nit): ?Empresa;

    public function actualizar(Empresa $empresa): Empresa;

    public function eliminarInactivas(): int;
}

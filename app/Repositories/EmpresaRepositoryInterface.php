<?php

namespace App\Repositories;

use App\Models\Empresa;
use Illuminate\Support\Collection;

interface EmpresaRepositoryInterface
{
    public function crear(array $data): Empresa;
    public function obtenerTodas(): Collection;
    public function obtenerPorNit(string $nit): ?Empresa;
    public function actualizar(Empresa $empresa, array $data): Empresa;
    public function eliminarInactivas(): int;
}

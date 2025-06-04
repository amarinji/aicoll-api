<?php

namespace App\Repositories;

use App\Models\Empresa;
use Illuminate\Support\Collection;

class EmpresaRepository implements EmpresaRepositoryInterface
{
    public function crear(array $data): Empresa
    {
        return Empresa::create($data);
    }

    public function obtenerTodas(): Collection
    {
        return Empresa::all();
    }

    public function obtenerPorNit(string $nit): ?Empresa
    {
        return Empresa::where('nit', $nit)->first();
    }

    public function actualizar(Empresa $empresa, array $data): Empresa
    {
        $empresa->update($data);
        return $empresa;
    }

    public function eliminarInactivas(): int
    {
        return Empresa::where('estado', 'inactivo')->delete();
    }
}

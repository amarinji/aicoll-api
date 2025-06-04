<?php

namespace App\Application\DTOs;

use InvalidArgumentException;

class EmpresaDTO
{
    public string $nit;
    public string $nombre;
    public ?string $direccion;
    public ?string $telefono;

    public function __construct(array $data)
    {
        $this->setNit($data['nit'] ?? null);
        $this->setNombre($data['nombre'] ?? null);
        $this->direccion = $data['direccion'] ?? null;
        $this->telefono = $data['telefono'] ?? null;
    }

    public function setNit(?string $nit): void
    {
        if (empty($nit) || !preg_match('/^\d+$/', $nit)) {
            throw new InvalidArgumentException("El NIT debe ser un número válido.");
        }
        $this->nit = $nit;
    }

    public function setNombre(?string $nombre): void
    {
        if (empty($nombre)) {
            throw new InvalidArgumentException("El nombre es obligatorio.");
        }
        $this->nombre = $nombre;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function telefonoFormateado(): ?string
    {
        if ($this->telefono === null) {
            return null;
        }
        return preg_replace('/\D+/', '', $this->telefono);
    }
}

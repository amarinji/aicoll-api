<?php

namespace App\Domain\Entities;

use InvalidArgumentException;

class Empresa
{
    private string $nit;
    private string $nombre;
    private ?string $direccion;
    private ?string $telefono;
    private string $estado;

    private const ESTADOS_VALIDOS = ['activo', 'inactivo'];

    public function __construct(
        string $nit,
        string $nombre,
        ?string $direccion = null,
        ?string $telefono = null,
        ?string $estado = 'activo'
    ) {
        $this->setNit($nit);
        $this->setNombre($nombre);
        $this->direccion = $direccion;
        $this->telefono = $telefono;
        $this->setEstado($estado);
    }

    private function setNit(string $nit): void
    {
        if (!preg_match('/^\d+$/', $nit)) {
            throw new InvalidArgumentException("NIT inválido.");
        }
        $this->nit = $nit;
    }

    public function getNit(): string
    {
        return $this->nit;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        if (trim($nombre) === '') {
            throw new InvalidArgumentException("El nombre es obligatorio.");
        }
        $this->nombre = $nombre;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(?string $direccion): void
    {
        $this->direccion = $direccion;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): void
    {
        $this->telefono = $telefono;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }

    public function setEstado(?string $estado): void
    {
        $estado = $estado ?? 'activo';

        if (!in_array($estado, self::ESTADOS_VALIDOS, true)) {
            throw new InvalidArgumentException("Estado inválido.");
        }

        $this->estado = $estado;
    }

    public function activar(): void
    {
        $this->estado = 'activo';
    }

    public function desactivar(): void
    {
        $this->estado = 'inactivo';
    }
}

<?php

namespace App\Application\DTOs;

use InvalidArgumentException;

final class EmpresaDTO
{
    public readonly string      $nit;
    public readonly string      $nombre;
    public readonly ?string     $direccion;
    public readonly ?string     $telefono;
    public readonly ?string     $estado;

    public function __construct(
        string $nit,
        string  $nombre,
        ?string $direccion = null,
        ?string $telefono  = null,
        ?string $estado    = null
    ) {
        if ($nit === null || trim($nit) === '') {
            throw new InvalidArgumentException("El NIT debe ser un número válido.");
        }

        if (! preg_match('/^\d+$/', $nit)) {
            throw new InvalidArgumentException("El NIT debe ser un número válido.");
        }

        if (trim($nombre) === '') {
            throw new InvalidArgumentException("El nombre es obligatorio.");
        }

        $this->nit       = $nit;
        $this->nombre    = $nombre;
        $this->direccion = $direccion;
        $this->telefono  = $telefono;
        $this->estado    = $estado;
    }

    public static function createWithoutNit(
        string      $nombre,
        ?string     $direccion = null,
        ?string     $telefono  = null,
        ?string     $estado    = null
    ): self {
        return new self("0", $nombre, $direccion, $telefono, $estado);
    }

    public function getNit(): string
    {
        return $this->nit;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function telefonoFormateado(): ?string
    {
        return $this->telefono !== null
            ? preg_replace('/\D+/', '', $this->telefono)
            : null;
    }

    public function setNit(?string $nit): void
    {
        $this->nit = $nit;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function setDireccion(?string $direccion): void
    {
        $this->direccion = $direccion;
    }

    public function setTelefono(?string $telefono): void
    {
        $this->telefono = $telefono;
    }

    public function setEstado(?string $estado): void
    {
        $this->estado = $estado;
    }

    public function toArray(): array
    {
        return [
            'nit' => $this->nit,
            'nombre' => $this->nombre,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'estado' => $this->estado,
        ];
    }
}

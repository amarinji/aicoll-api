<?php

namespace App\Application\DTOs;

use InvalidArgumentException;

/**
 * DTO que representa una Empresa
 *
 * @property string $nit
 * @property string $nombre
 * @property string|null $direccion
 * @property string|null $telefono
 */
final class EmpresaDTO
{
    public readonly string $nit;
    public readonly string $nombre;
    public readonly ?string $direccion;
    public readonly ?string $telefono;

    public function __construct(
        string $nit,
        string $nombre,
        ?string $direccion = null,
        ?string $telefono = null
    ) {
        if (!preg_match('/^\d+$/', $nit)) {
            throw new InvalidArgumentException("El NIT debe ser un número válido.");
        }
        if (empty($nit)) {
            throw new InvalidArgumentException("NIT no puede estar vacío.");
        }
        if (empty($nombre)) {
            throw new InvalidArgumentException("El nombre es obligatorio.");
        }

        $this->nit = $nit;
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['nit'] ?? '',
            $data['nombre'] ?? '',
            $data['direccion'] ?? null,
            $data['telefono'] ?? null,
        );
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

    public function telefonoFormateado(): ?string
    {
        return $this->telefono !== null
            ? preg_replace('/\D+/', '', $this->telefono)
            : null;
    }
}

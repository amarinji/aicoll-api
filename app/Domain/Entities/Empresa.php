<?php

namespace App\Domain\Entities;

class Empresa
{
    public function __construct(
        public readonly string $nit,
        public string $nombre,
        public ?string $direccion = null,
        public ?string $telefono = null,
        public string $estado = 'activo'
    ) {}
}

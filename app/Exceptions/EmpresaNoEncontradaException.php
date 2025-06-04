<?php

namespace App\Exceptions;

use Exception;

class EmpresaNoEncontradaException extends Exception
{
    public function __construct(string $nit)
    {
        parent::__construct("Empresa con NIT {$nit} no encontrada", 404);
    }
}
<?php

namespace App\Exceptions;

use Exception;

class EmpresaNoEncontradaException extends Exception
{
    public const NOT_FOUND_CODE = 404;

    public function __construct(string $nit)
    {
        parent::__construct("Empresa con NIT {$nit} no encontrada", self::NOT_FOUND_CODE);
    }
}

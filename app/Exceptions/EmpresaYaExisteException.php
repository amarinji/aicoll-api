<?php

namespace App\Exceptions;

use Exception;

class EmpresaYaExisteException extends Exception
{
    public function __construct(string $nit)
    {
        parent::__construct("Ya existe una empresa con el NIT {$nit}", 409);
    }
}

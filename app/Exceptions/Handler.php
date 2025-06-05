<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Exceptions\EmpresaNoEncontradaException;

class Handler extends ExceptionHandler
{
 
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof EmpresaNoEncontradaException) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 404);
        }

        return parent::render($request, $exception);
    }
}

<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Exceptions\EmpresaNoEncontradaException;

class Handler extends ExceptionHandler
{
    protected $levels = [
        // puedes dejar esto vacío
    ];

    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->renderable(function (EmpresaNoEncontradaException $e, $request) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode() ?: 404);
        });
    }
}

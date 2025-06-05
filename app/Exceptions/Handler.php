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
            return $this->jsonError($e, 'Empresa no encontrada');
        });

        $this->renderable(function (EmpresaYaExisteException $e, $request) {
            return $this->jsonError($e, 'Conflicto al crear empresa');
        });

        // puedes agregar más aquí
    }

    protected function jsonError(\Exception $e, string $defaultError): \Illuminate\Http\JsonResponse
    {
        $status = is_int($e->getCode()) && $e->getCode() >= 100 && $e->getCode() <= 599
            ? $e->getCode()
            : 400;

        return response()->json([
            'error' => $defaultError,
            'message' => $e->getMessage()
        ], $status);
    }
}

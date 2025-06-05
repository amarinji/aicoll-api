<?php

namespace App\Exceptions\Traits;

use Illuminate\Http\JsonResponse;
use Throwable;

trait HandleCustomExceptionsTrait
{
    public function handleCustomException(Throwable $exception): ?JsonResponse
    {
        $exceptionMap = [
            \App\Exceptions\EmpresaNoEncontradaException::class => 404,
            \App\Exceptions\EmpresaYaExisteException::class => 409,
        ];

        foreach ($exceptionMap as $exceptionClass => $statusCode) {
            if ($exception instanceof $exceptionClass) {
                return response()->json([
                    'message' => $exception->getMessage(),
                ], $statusCode);
            }
        }

        return null;
    }
}

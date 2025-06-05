<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Exceptions\Traits\HandleCustomExceptionsTrait;


class Handler extends ExceptionHandler
{
    use HandleCustomExceptionsTrait;

    public function render($request, Throwable $exception)
    {
        $customResponse = $this->handleCustomException($exception);

        if ($customResponse !== null) {
            return $customResponse;
        }

        return parent::render($request, $exception);
    }
}

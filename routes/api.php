<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmpresaController;
use App\Exceptions\EmpresaNoEncontradaException;

Route::get('/test', function () {
    throw new EmpresaNoEncontradaException('123456789');
});

Route::prefix('empresa')->group(function () {
    Route::get('/', [EmpresaController::class, 'index']);
    Route::post('/', [EmpresaController::class, 'store']);
    Route::get('/{nit}', [EmpresaController::class, 'show']);
    Route::put('/{nit}', [EmpresaController::class, 'update']);
    Route::delete('/inactivas', [EmpresaController::class, 'destroyInactivas']);
});



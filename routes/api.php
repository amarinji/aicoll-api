<?php
use Illuminate\Support\Facades\Route;
use App\Interfaces\Http\Controllers\Api\EmpresaController;
use App\Exceptions\EmpresaNoEncontradaException;

Route::prefix('empresa')->group(function () {
    Route::get('/', [EmpresaController::class, 'index']);
    Route::post('/', [EmpresaController::class, 'store']);
    Route::get('/{nit}', [EmpresaController::class, 'show']);
    Route::put('/{nit}', [EmpresaController::class, 'update']);
    Route::delete('/inactivas', [EmpresaController::class, 'destroyInactivas']);
});



<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmpresaController;

Route::get('/ping', function () {
    return response()->json(['pong' => true]);
});

Route::prefix('empresa')->group(function () {
    Route::get('/', [EmpresaController::class, 'index']);
    Route::post('/', [EmpresaController::class, 'store']);
    Route::get('/{nit}', [EmpresaController::class, 'show']);
    Route::put('/{nit}', [EmpresaController::class, 'update']);
    Route::delete('/inactivas', [EmpresaController::class, 'destroyInactivas']);
});



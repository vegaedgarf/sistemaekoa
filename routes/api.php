<?php

use Illuminate\Support\Facades\Route;

// Importaciones estrictas a la carpeta Api
use App\Http\Controllers\Api\ComprobanteController;
use App\Http\Controllers\Api\CatalogoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| El prefijo 'api/' se agrega automáticamente a todas estas rutas.
*/

Route::prefix('v1')->group(function () {
    Route::post('/comprobantes', [ComprobanteController::class, 'store']);
    Route::get('/catalogos/{tipo}', [CatalogoController::class, 'show']); 
});
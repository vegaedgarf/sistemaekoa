<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/recepcion/nuevo', function () {
    return view('recepcion.create');
});
/*
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ComprobanteController;
use App\Http\Controllers\Api\CatalogoController;

Route::get('/', function () {
    return view('home');
});

// Agregamos 'api/' al prefijo para que coincida con el fetch de JS
Route::prefix('api/v1')->group(function () {
    Route::post('/comprobantes', [ComprobanteController::class, 'store']);
    Route::get('/catalogos/{tipo}', [CatalogoController::class, 'show']); // Catálogos dinámicos
});

Route::get('/recepcion/nuevo', function () {
    return view('recepcion.create');
});*/
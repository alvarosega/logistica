<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\OrderSearchController;

// Silo Público: Consulta de pedidos sin login
Route::get('/', [OrderSearchController::class, 'index'])->name('home');

// Rutas de autenticación (Breeze)
require __DIR__.'/auth.php';
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Eco\EcoController; // Asegura que el namespace sea correcto

// Ahora la URL real coincide con la redirección: /eco/
Route::get('/', [EcoController::class, 'index'])->name('eco.dashboard');
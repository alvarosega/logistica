<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// La URL real será: /admin/dashboard
Route::get('/dashboard', function () {
    return Inertia::render('Admin/Index');
})->name('admin.dashboard');

// Aquí agregaremos luego las rutas POST para subir los CSV
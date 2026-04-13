<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\InvitadoController;

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin' 
            ? redirect()->route('admin.dashboard') 
            : redirect()->route('invitado.dashboard');
    }
    return redirect()->route('login');
});
// Grupo para el Administrador
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Admin/Index');
    })->name('admin.dashboard');
});

Route::middleware(['auth', 'role:invitado'])->prefix('invitado')->group(function () {
    Route::get('/dashboard', [InvitadoController::class, 'index'])->name('invitado.dashboard');
});

// Perfil común (opcional, puedes moverlo dentro de los grupos si prefieres layouts distintos)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
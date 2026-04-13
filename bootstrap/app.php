<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        // Aquí registramos los archivos de rutas separados por silo
        then: function () {
            Route::middleware(['web', 'auth', 'role:admin'])
                ->prefix('admin')
                ->group(base_path('routes/admin.php'));

            Route::middleware(['web', 'auth', 'role:eco'])
                ->prefix('eco')
                ->group(base_path('routes/eco.php'));

        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);
    
        // Registro del alias único
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    
        $middleware->redirectGuestsTo(fn () => route('login'));
    
        // Redirección calculada basada en el nuevo esquema de 3 roles
        $middleware->redirectUsersTo(function () {
            $role = auth()->user()->role;
            return match ($role) {
                'admin' => '/admin/dashboard',
                'eco' => '/eco/',
                default => '/',
            };
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
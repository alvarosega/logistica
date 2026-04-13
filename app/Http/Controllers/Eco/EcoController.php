<?php

namespace App\Http\Controllers\Eco;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EcoController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Si es un usuario ECO sin territorio, devolvemos colección vacía por seguridad
        if ($user->role === 'eco' && is_null($user->territorio)) {
            return Inertia::render('Eco/Index', [
                'orders' => [
                    'data' => [],
                    'links' => []
                ]
            ]);
        }

        // Cargamos los pedidos del territorio del usuario con sus respectivos camiones
        $orders = $user->orders()
            ->with('truck')
            ->orderBy('fecha_entrega', 'asc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Eco/Index', [
            'orders' => $orders,
            'user_territorio' => $user->territorio
        ]);
    }
}
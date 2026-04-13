<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class InvitadoController extends Controller
{
    public function index(Request $request)
    {
        // Importante: Esto asume que el modelo User tiene definida la relación 'orders'
        // usando 'codigo_cliente' como llave local y foránea.
        $orders = $request->user()->orders()
            ->with('truck') 
            ->orderBy('fecha_entrega', 'asc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Invitado/Index', [
            'orders' => $orders
        ]);
    }
}
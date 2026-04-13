<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderSearchController extends Controller
{
    public function index(Request $request)
    {
        $codigo = $request->input('codigo');
        $orders = null;

        if ($codigo) {
            $orders = Order::where('codigo_cliente', $codigo)
                ->with('truck') // Relación con el transportista
                ->orderBy('fecha_entrega', 'asc')
                ->paginate(10)
                ->withQueryString();
        }

        // Renderiza la vista en la carpeta Client
        return Inertia::render('Client/Search', [
            'orders' => $orders,
            'filters' => $request->only(['codigo'])
        ]);
    }
}
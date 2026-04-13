<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_cliente',
        'razon_social', // Añadido
        'territorio',   // Añadido
        'codigo_camion',
        'fecha_entrega',
        'producto',
        'cantidad',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'codigo_cliente', 'codigo_cliente');
    }
    /**
     * Relación: El pedido pertenece a un camión.
     */
    public function truck(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        // foreignKey en 'orders': codigo_camion
        // ownerKey en 'trucks': codigo_camion
        return $this->belongsTo(Truck::class, 'codigo_camion', 'codigo_camion');
    }
}   
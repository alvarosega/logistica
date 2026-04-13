<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
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
        return $this->belongsTo(Truck::class, 'codigo_camion', 'codigo_camion');
    }
}   
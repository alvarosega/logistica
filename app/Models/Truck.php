<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Truck extends Model
{
    use HasFactory;

    protected $fillable = ['codigo_camion', 'sru', 'region', 'cel', 'nombre'];

    /**
     * Relación: Un camión tiene muchos pedidos asignados.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'codigo_camion', 'codigo_camion');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'legajo', 
        'password',
        'role',
        'territorio',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Relación con pedidos. 
     * Tanto el silo ECO como CLIENTE utilizarán esta relación.
     */
    public function orders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        // foreignKey en Order: territorio
        // localKey en User: territorio
        return $this->hasMany(Order::class, 'territorio', 'territorio');
    }
}
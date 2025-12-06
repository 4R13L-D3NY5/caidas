<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Escala extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'tipo',
        'descripcion',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(ItemEscala::class);
    }

    public function nivelesRiesgo(): HasMany
    {
        return $this->hasMany(NivelRiesgo::class);
    }
}

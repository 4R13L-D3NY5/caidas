<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NivelRiesgo extends Model
{
    use HasFactory;

    protected $table = 'niveles_riesgo';

    protected $fillable = [
        'escala_id',
        'nombre',
        'puntaje_min',
        'puntaje_max',
        'color',
        'codigo_color',
    ];

    public function escala(): BelongsTo
    {
        return $this->belongsTo(Escala::class);
    }

    public function accionesRecomendadas(): HasMany
    {
        return $this->hasMany(AccionRecomendada::class)->orderBy('orden');
    }
}

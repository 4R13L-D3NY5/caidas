<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Valoracion extends Model
{
    use HasFactory;

    protected $table = 'valoraciones';

    protected $fillable = [
        'admision_id',
        'tipo_valoracion',
        'puntaje_total',
        'nivel_riesgo_id',
    ];

    public function admision(): BelongsTo
    {
        return $this->belongsTo(Admision::class);
    }

    public function nivelRiesgo(): BelongsTo
    {
        return $this->belongsTo(NivelRiesgo::class);
    }

    public function respuestas(): HasMany
    {
        return $this->hasMany(RespuestaValoracion::class);
    }
}

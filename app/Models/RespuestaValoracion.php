<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RespuestaValoracion extends Model
{
    use HasFactory;

    protected $table = 'respuestas_valoracion';

    protected $fillable = [
        'valoracion_id',
        'item_escala_id',
        'opcion_escala_id',
    ];

    public function valoracion(): BelongsTo
    {
        return $this->belongsTo(Valoracion::class);
    }

    public function itemEscala(): BelongsTo
    {
        return $this->belongsTo(ItemEscala::class);
    }

    public function opcionEscala(): BelongsTo
    {
        return $this->belongsTo(OpcionEscala::class);
    }
}

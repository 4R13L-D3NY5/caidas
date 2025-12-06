<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OpcionEscala extends Model
{
    use HasFactory;

    protected $table = 'opciones_escala';

    protected $fillable = [
        'item_escala_id',
        'criterio',
        'puntaje',
    ];

    public function itemEscala(): BelongsTo
    {
        return $this->belongsTo(ItemEscala::class);
    }
}

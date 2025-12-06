<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemListaCotejo extends Model
{
    use HasFactory;

    protected $table = 'items_lista_cotejo';

    protected $fillable = [
        'lista_cotejo_id',
        'accion_recomendada_id',
        'aplicada',
        'observacion',
    ];

    protected $casts = [
        'aplicada' => 'boolean',
    ];

    public function listaCotejo(): BelongsTo
    {
        return $this->belongsTo(ListaCotejo::class);
    }

    public function accionRecomendada(): BelongsTo
    {
        return $this->belongsTo(AccionRecomendada::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemEscala extends Model
{
    use HasFactory;

    protected $table = 'items_escala';

    protected $fillable = [
        'escala_id',
        'numero',
        'nombre',
        'descripcion',
    ];

    public function escala(): BelongsTo
    {
        return $this->belongsTo(Escala::class);
    }

    public function opciones(): HasMany
    {
        return $this->hasMany(OpcionEscala::class);
    }
}

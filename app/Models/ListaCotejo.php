<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ListaCotejo extends Model
{
    use HasFactory;

    protected $table = 'listas_cotejo';

    protected $fillable = [
        'admision_id',
        'seguimiento_diario_id',
        'user_id',
        'fecha_verificacion',
        'porcentaje_cumplimiento',
    ];

    protected $casts = [
        'fecha_verificacion' => 'date',
        'porcentaje_cumplimiento' => 'decimal:2',
    ];

    public function admision(): BelongsTo
    {
        return $this->belongsTo(Admision::class);
    }

    public function seguimientoDiario(): BelongsTo
    {
        return $this->belongsTo(SeguimientoDiario::class);
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ItemListaCotejo::class);
    }
}

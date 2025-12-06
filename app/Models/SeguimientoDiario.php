<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SeguimientoDiario extends Model
{
    use HasFactory;

    protected $table = 'seguimientos_diarios';

    protected $fillable = [
        'admision_id',
        'fecha',
        'turno',
        'hubo_caida',
        'hora_caida',
        'lugar',
        'tipo_caida',
        'hubo_lesion',
        'descripcion_lesion',
        'acciones_tomadas',
        'observacion',
        // Campos para úlceras
        'hubo_ulcera',
        'estado_ulcera',
        'descripcion_ulcera',
        'ubicacion_ulcera',
        'observaciones_ulcera',
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora_caida' => 'datetime:H:i',
        'hubo_caida' => 'boolean',
        'hubo_lesion' => 'boolean',
        'hubo_ulcera' => 'boolean',
        'acciones_tomadas' => 'array',
    ];

    public function admision(): BelongsTo
    {
        return $this->belongsTo(Admision::class);
    }

    public function listasCotejo(): HasMany
    {
        return $this->hasMany(ListaCotejo::class);
    }
}

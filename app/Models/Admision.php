<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admision extends Model
{
    use HasFactory;

    protected $table = 'admisiones';

    protected $fillable = [
        'paciente_id',
        'tipo',
        'estado',
        'turno',
        'fecha_valoracion',
        'diagnostico_inicial',
        'diagnostico_final',
        'fecha_alta',
    ];

    protected $casts = [
        'fecha_valoracion' => 'date',
        'fecha_alta' => 'date',
    ];

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class);
    }

    public function valoraciones(): HasMany
    {
        return $this->hasMany(Valoracion::class);
    }

    public function seguimientosDiarios(): HasMany
    {
        return $this->hasMany(SeguimientoDiario::class);
    }

    public function listasCotejo(): HasMany
    {
        return $this->hasMany(ListaCotejo::class);
    }

    public function valoracionInicial()
    {
        return $this->valoraciones()->where('tipo_valoracion', 'inicial')->first();
    }

    public function valoracionAlta()
    {
        return $this->valoraciones()->where('tipo_valoracion', 'alta')->first();
    }
}

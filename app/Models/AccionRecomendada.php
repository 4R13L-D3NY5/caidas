<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccionRecomendada extends Model
{
    use HasFactory;

    protected $table = 'acciones_recomendadas';

    protected $fillable = [
        'nivel_riesgo_id',
        'descripcion',
        'orden',
    ];

    public function nivelRiesgo(): BelongsTo
    {
        return $this->belongsTo(NivelRiesgo::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'matricula',
        'fecha_nacimiento',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    // Accessor para calcular la edad automáticamente
    public function getEdadAttribute()
    {
        return $this->fecha_nacimiento ? Carbon::parse($this->fecha_nacimiento)->age : null;
    }

    public function admisiones(): HasMany
    {
        return $this->hasMany(Admision::class);
    }
}

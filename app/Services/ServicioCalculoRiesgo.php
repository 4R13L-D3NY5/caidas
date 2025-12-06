<?php

namespace App\Services;

use App\Models\NivelRiesgo;
use App\Models\Escala;

class ServicioCalculoRiesgo
{
    /**
     * Calcula el nivel de riesgo basado en el puntaje total y el tipo de escala
     */
    public function calcularNivelRiesgo(int $puntajeTotal, string $tipoEscala): ?NivelRiesgo
    {
        $escala = Escala::where('tipo', $tipoEscala)->first();
        
        if (!$escala) {
            return null;
        }

        return NivelRiesgo::where('escala_id', $escala->id)
            ->where('puntaje_min', '<=', $puntajeTotal)
            ->where('puntaje_max', '>=', $puntajeTotal)
            ->first();
    }

    /**
     * Calcula el puntaje total de una valoración
     */
    public function calcularPuntajeTotal(array $respuestas): int
    {
        return collect($respuestas)->sum('puntaje');
    }
}

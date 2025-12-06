<?php

namespace App\Services;

use App\Models\NivelRiesgo;
use App\Models\AccionRecomendada;
use Illuminate\Support\Collection;

class ServicioRecomendacionAcciones
{
    /**
     * Obtiene todas las acciones recomendadas para un nivel de riesgo
     * Para caídas: incluye acciones acumulativas (del nivel actual y todos los inferiores)
     * Para úlceras: solo las acciones específicas del nivel
     */
    public function obtenerAccionesRecomendadas(NivelRiesgo $nivelRiesgo): Collection
    {
        $escala = $nivelRiesgo->escala;
        
        // Para caídas, las acciones son acumulativas
        if ($escala->tipo === 'caida') {
            return $this->obtenerAccionesAcumulativas($nivelRiesgo);
        }
        
        // Para úlceras, solo las acciones del nivel específico
        return $nivelRiesgo->accionesRecomendadas;
    }

    /**
     * Obtiene acciones acumulativas (nivel actual + niveles inferiores)
     */
    private function obtenerAccionesAcumulativas(NivelRiesgo $nivelRiesgo): Collection
    {
        $escala = $nivelRiesgo->escala;
        
        // Obtener todos los niveles de riesgo de la misma escala con puntaje menor o igual
        $nivelesAplicables = NivelRiesgo::where('escala_id', $escala->id)
            ->where('puntaje_max', '<=', $nivelRiesgo->puntaje_max)
            ->get();
        
        // Recopilar todas las acciones de esos niveles
        $acciones = collect();
        foreach ($nivelesAplicables as $nivel) {
            $acciones = $acciones->merge($nivel->accionesRecomendadas);
        }
        
        // Ordenar por orden
        return $acciones->sortBy('orden')->values();
    }

    /**
     * Calcula el porcentaje de cumplimiento de acciones
     */
    public function calcularPorcentajeCumplimiento(int $accionesAplicadas, int $accionesTotales): float
    {
        if ($accionesTotales === 0) {
            return 0;
        }
        
        return round(($accionesAplicadas / $accionesTotales) * 100, 2);
    }
}

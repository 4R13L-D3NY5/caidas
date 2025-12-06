<?php

namespace App\Services;

use App\Models\Admision;
use App\Models\SeguimientoDiario;
use App\Models\ListaCotejo;
use Illuminate\Support\Facades\DB;

class ServicioReportes
{
    /**
     * Reporte de Pacientes con filtros
     */
    public function reportePacientes($filtros = [])
    {
        $query = Admision::with(['paciente', 'valoraciones.nivelRiesgo']);

        // Filtro por estado
        if (!empty($filtros['estado']) && $filtros['estado'] !== 'todos') {
            $query->where('estado', $filtros['estado']);
        }

        // Filtro por tipo
        if (!empty($filtros['tipo']) && $filtros['tipo'] !== 'todos') {
            $query->where('tipo', $filtros['tipo']);
        }

        // Filtro por rango de fechas
        if (!empty($filtros['fecha_inicio'])) {
            $query->whereDate('fecha_valoracion', '>=', $filtros['fecha_inicio']);
        }
        if (!empty($filtros['fecha_fin'])) {
            $query->whereDate('fecha_valoracion', '<=', $filtros['fecha_fin']);
        }

        // Filtro por nivel de riesgo
        if (!empty($filtros['nivel_riesgo'])) {
            $query->whereHas('valoraciones.nivelRiesgo', function($q) use ($filtros) {
                $q->where('nombre', $filtros['nivel_riesgo']);
            });
        }

        return $query->orderBy('fecha_valoracion', 'desc')->get();
    }

    /**
     * Reporte de Caídas con filtros
     */
    public function reporteCaidas($filtros = [])
    {
        $query = SeguimientoDiario::with(['admision.paciente'])
            ->where('hubo_caida', true);

        // Filtro por rango de fechas
        if (!empty($filtros['fecha_inicio'])) {
            $query->whereDate('fecha', '>=', $filtros['fecha_inicio']);
        }
        if (!empty($filtros['fecha_fin'])) {
            $query->whereDate('fecha', '<=', $filtros['fecha_fin']);
        }

        // Filtro por turno
        if (!empty($filtros['turno']) && $filtros['turno'] !== 'todos') {
            $query->where('turno', $filtros['turno']);
        }

        // Filtro por tipo de caída
        if (!empty($filtros['tipo_caida']) && $filtros['tipo_caida'] !== 'todos') {
            $query->where('tipo_caida', $filtros['tipo_caida']);
        }

        // Filtro por lesión
        if (isset($filtros['con_lesion'])) {
            $query->where('hubo_lesion', $filtros['con_lesion']);
        }

        $caidas = $query->orderBy('fecha', 'desc')->get();

        // Estadísticas
        $estadisticas = [
            'total' => $caidas->count(),
            'con_lesion' => $caidas->where('hubo_lesion', true)->count(),
            'por_turno' => $caidas->groupBy('turno')->map->count(),
            'por_tipo' => $caidas->groupBy('tipo_caida')->map->count(),
        ];

        return [
            'caidas' => $caidas,
            'estadisticas' => $estadisticas,
        ];
    }

    /**
     * Reporte de Cumplimiento con filtros
     */
    public function reporteCumplimiento($filtros = [])
    {
        $query = ListaCotejo::with(['admision.paciente', 'supervisor', 'seguimientoDiario']);

        // Filtro por rango de fechas
        if (!empty($filtros['fecha_inicio'])) {
            $query->whereDate('fecha_verificacion', '>=', $filtros['fecha_inicio']);
        }
        if (!empty($filtros['fecha_fin'])) {
            $query->whereDate('fecha_verificacion', '<=', $filtros['fecha_fin']);
        }

        // Filtro por supervisor
        if (!empty($filtros['supervisor_id'])) {
            $query->where('user_id', $filtros['supervisor_id']);
        }

        // Filtro por nivel de cumplimiento mínimo
        if (!empty($filtros['cumplimiento_minimo'])) {
            $query->where('porcentaje_cumplimiento', '>=', $filtros['cumplimiento_minimo']);
        }

        $listas = $query->orderBy('fecha_verificacion', 'desc')->get();

        // Estadísticas
        $estadisticas = [
            'total_verificaciones' => $listas->count(),
            'promedio_cumplimiento' => $listas->avg('porcentaje_cumplimiento'),
            'cumplimiento_alto' => $listas->where('porcentaje_cumplimiento', '>=', 80)->count(),
            'cumplimiento_medio' => $listas->whereBetween('porcentaje_cumplimiento', [60, 79])->count(),
            'cumplimiento_bajo' => $listas->where('porcentaje_cumplimiento', '<', 60)->count(),
        ];

        return [
            'listas' => $listas,
            'estadisticas' => $estadisticas,
        ];
    }

    /**
     * Reporte Estadístico General
     */
    public function reporteEstadistico($filtros = [])
    {
        $fechaInicio = $filtros['fecha_inicio'] ?? now()->subMonth()->format('Y-m-d');
        $fechaFin = $filtros['fecha_fin'] ?? now()->format('Y-m-d');

        // Admisiones
        $admisiones = Admision::whereBetween('fecha_valoracion', [$fechaInicio, $fechaFin]);
        if (!empty($filtros['tipo']) && $filtros['tipo'] !== 'todos') {
            $admisiones->where('tipo', $filtros['tipo']);
        }
        $admisiones = $admisiones->with('valoraciones.nivelRiesgo')->get();

        // Caídas
        $caidas = SeguimientoDiario::where('hubo_caida', true)
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->get();

        // Cumplimiento
        $cumplimiento = ListaCotejo::whereBetween('fecha_verificacion', [$fechaInicio, $fechaFin])
            ->avg('porcentaje_cumplimiento');

        // Distribución por nivel de riesgo
        $distribucionRiesgo = $admisiones->map(function($admision) {
            $valoracion = $admision->valoraciones->where('tipo_valoracion', 'inicial')->first();
            return $valoracion ? $valoracion->nivelRiesgo->nombre : null;
        })->filter()->countBy();

        return [
            'periodo' => [
                'inicio' => $fechaInicio,
                'fin' => $fechaFin,
            ],
            'admisiones' => [
                'total' => $admisiones->count(),
                'activas' => $admisiones->where('estado', 'activo')->count(),
                'altas' => $admisiones->where('estado', 'alta')->count(),
                'por_tipo' => $admisiones->groupBy('tipo')->map->count(),
            ],
            'caidas' => [
                'total' => $caidas->count(),
                'con_lesion' => $caidas->where('hubo_lesion', true)->count(),
                'por_turno' => $caidas->groupBy('turno')->map->count(),
            ],
            'cumplimiento' => round($cumplimiento, 2),
            'distribucion_riesgo' => $distribucionRiesgo,
        ];
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\ServicioReportes;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportePDFController extends Controller
{
    protected $servicioReportes;

    public function __construct(ServicioReportes $servicioReportes)
    {
        $this->servicioReportes = $servicioReportes;
    }

    public function pacientes(Request $request)
    {
        $filtros = $request->only(['estado', 'tipo', 'fecha_inicio', 'fecha_fin', 'nivel_riesgo']);
        $datos = $this->servicioReportes->reportePacientes($filtros);

        $pdf = Pdf::loadView('pdf.reportes.pacientes', [
            'pacientes' => $datos,
            'filtros' => $filtros,
            'fecha_generacion' => now(),
        ]);

        return $pdf->download('reporte-pacientes-' . now()->format('Y-m-d') . '.pdf');
    }

    public function caidas(Request $request)
    {
        $filtros = $request->only(['fecha_inicio', 'fecha_fin', 'turno', 'tipo_caida', 'con_lesion']);
        $resultado = $this->servicioReportes->reporteCaidas($filtros);

        $pdf = Pdf::loadView('pdf.reportes.caidas', [
            'caidas' => $resultado['caidas'],
            'estadisticas' => $resultado['estadisticas'],
            'filtros' => $filtros,
            'fecha_generacion' => now(),
        ]);

        return $pdf->download('reporte-caidas-' . now()->format('Y-m-d') . '.pdf');
    }

    public function cumplimiento(Request $request)
    {
        $filtros = $request->only(['fecha_inicio', 'fecha_fin', 'supervisor_id', 'cumplimiento_minimo']);
        $resultado = $this->servicioReportes->reporteCumplimiento($filtros);

        $pdf = Pdf::loadView('pdf.reportes.cumplimiento', [
            'listas' => $resultado['listas'],
            'estadisticas' => $resultado['estadisticas'],
            'filtros' => $filtros,
            'fecha_generacion' => now(),
        ]);

        return $pdf->download('reporte-cumplimiento-' . now()->format('Y-m-d') . '.pdf');
    }

    public function estadistico(Request $request)
    {
        $filtros = $request->only(['fecha_inicio', 'fecha_fin', 'tipo']);
        $datos = $this->servicioReportes->reporteEstadistico($filtros);

        $pdf = Pdf::loadView('pdf.reportes.estadistico', [
            'datos' => $datos,
            'filtros' => $filtros,
            'fecha_generacion' => now(),
        ]);

        return $pdf->download('reporte-estadistico-' . now()->format('Y-m-d') . '.pdf');
    }
}

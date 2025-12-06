<?php

namespace App\Http\Controllers;

use App\Models\Admision;
use App\Services\ServicioRecomendacionAcciones;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class HistorialPDFController extends Controller
{
    protected $servicioAcciones;

    public function __construct(ServicioRecomendacionAcciones $servicioAcciones)
    {
        $this->servicioAcciones = $servicioAcciones;
    }

    public function exportar($admisionId)
    {
        $admision = Admision::with([
            'paciente',
            'valoraciones.nivelRiesgo.escala',
            'valoraciones.respuestas.itemEscala',
            'valoraciones.respuestas.opcionEscala',
            'seguimientosDiarios',
            'listasCotejo.items.accionRecomendada',
            'listasCotejo.supervisor'
        ])->findOrFail($admisionId);

        $valoracionInicial = $admision->valoraciones->where('tipo_valoracion', 'inicial')->first();
        $valoracionAlta = $admision->valoraciones->where('tipo_valoracion', 'alta')->first();
        $seguimientos = $admision->seguimientosDiarios()->orderBy('fecha', 'asc')->get();
        $listasCotejo = $admision->listasCotejo;

        $accionesRecomendadas = [];
        if ($valoracionInicial) {
            $accionesRecomendadas = $this->servicioAcciones->obtenerAccionesRecomendadas(
                $valoracionInicial->nivelRiesgo
            );
        }

        $pdf = Pdf::loadView('pdf.historial-internacion', [
            'admision' => $admision,
            'valoracionInicial' => $valoracionInicial,
            'valoracionAlta' => $valoracionAlta,
            'seguimientos' => $seguimientos,
            'listasCotejo' => $listasCotejo,
            'accionesRecomendadas' => $accionesRecomendadas
        ]);

        $pdf->setPaper('letter', 'portrait');

        $nombreArchivo = 'Historial_' . $admision->paciente->matricula . '_' . now()->format('Ymd') . '.pdf';

        return $pdf->download($nombreArchivo);
    }
}

<?php

namespace App\Livewire;

use App\Models\Admision;
use App\Services\ServicioRecomendacionAcciones;
use Livewire\Component;

class HistorialImpresion extends Component
{
    public $admision;
    public $valoracionInicial;
    public $valoracionAlta;
    public $seguimientos;
    public $listasCotejo;
    public $accionesRecomendadas;

    protected $servicioAcciones;

    public function boot(ServicioRecomendacionAcciones $servicioAcciones)
    {
        $this->servicioAcciones = $servicioAcciones;
    }

    public function mount($admisionId)
    {
        $this->admision = Admision::with([
            'paciente',
            'valoraciones.nivelRiesgo.escala',
            'valoraciones.respuestas.itemEscala',
            'valoraciones.respuestas.opcionEscala',
            'seguimientosDiarios',
            'listasCotejo.items.accionRecomendada',
            'listasCotejo.supervisor'
        ])->findOrFail($admisionId);

        $this->valoracionInicial = $this->admision->valoraciones->where('tipo_valoracion', 'inicial')->first();
        $this->valoracionAlta = $this->admision->valoraciones->where('tipo_valoracion', 'alta')->first();
        $this->seguimientos = $this->admision->seguimientosDiarios()->orderBy('fecha', 'asc')->get();
        $this->listasCotejo = $this->admision->listasCotejo;

        if ($this->valoracionInicial) {
            $this->accionesRecomendadas = $this->servicioAcciones->obtenerAccionesRecomendadas(
                $this->valoracionInicial->nivelRiesgo
            );
        }
    }

    public function render()
    {
        return view('livewire.historial-impresion')->layout('layouts.print');
    }
}

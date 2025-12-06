<?php

namespace App\Livewire;

use App\Models\Admision;
use App\Services\ServicioRecomendacionAcciones;
use Livewire\Component;

class DashboardPaciente extends Component
{
    public $admision;
    public $valoracionInicial;
    public $nivelRiesgo;
    public $accionesRecomendadas;
    public $seguimientos;
    public $listasCotejo;

    protected $servicioAcciones;

    public function boot(ServicioRecomendacionAcciones $servicioAcciones)
    {
        $this->servicioAcciones = $servicioAcciones;
    }

    public function mount($admisionId)
    {
        $this->admision = Admision::with([
            'paciente',
            'valoraciones.nivelRiesgo',
            'seguimientosDiarios',
            'listasCotejo.items.accionRecomendada'
        ])->findOrFail($admisionId);

        $this->valoracionInicial = $this->admision->valoracionInicial();
        
        if ($this->valoracionInicial) {
            $this->nivelRiesgo = $this->valoracionInicial->nivelRiesgo;
            $this->accionesRecomendadas = $this->servicioAcciones->obtenerAccionesRecomendadas($this->nivelRiesgo);
        }

        $this->seguimientos = $this->admision->seguimientosDiarios()->orderBy('fecha', 'desc')->get();
        $this->listasCotejo = $this->admision->listasCotejo()->orderBy('fecha_verificacion', 'desc')->get();
    }

    public function marcarLlamadaAtencion($cotejoId)
    {
        $cotejo = \App\Models\ListaCotejo::findOrFail($cotejoId);
        
        // Verificar que pertenece a esta admisión
        if ($cotejo->admision_id !== $this->admision->id) {
            session()->flash('error', 'No tiene permisos para realizar esta acción.');
            return;
        }

        $cotejo->update(['llamada_atencion' => true]);
        
        session()->flash('success', 'Llamada de atención marcada correctamente.');
        
        // Recargar datos
        $this->mount($this->admision->id);
    }

    public function quitarLlamadaAtencion($cotejoId)
    {
        $cotejo = \App\Models\ListaCotejo::findOrFail($cotejoId);
        
        // Verificar que pertenece a esta admisión
        if ($cotejo->admision_id !== $this->admision->id) {
            session()->flash('error', 'No tiene permisos para realizar esta acción.');
            return;
        }

        $cotejo->update(['llamada_atencion' => false]);
        
        session()->flash('success', 'Llamada de atención removida correctamente.');
        
        // Recargar datos
        $this->mount($this->admision->id);
    }

    public function render()
    {
        return view('livewire.dashboard-paciente');
    }
}

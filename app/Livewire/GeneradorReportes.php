<?php

namespace App\Livewire;

use App\Services\ServicioReportes;
use App\Models\User;
use Livewire\Component;

class GeneradorReportes extends Component
{
    public $tipoReporte = 'pacientes';
    
    // Filtros comunes
    public $fecha_inicio = '';
    public $fecha_fin = '';
    
    // Filtros específicos de pacientes
    public $estado = 'todos';
    public $tipo = 'todos';
    public $nivel_riesgo = '';
    
    // Filtros específicos de caídas
    public $turno = 'todos';
    public $tipo_caida = 'todos';
    public $con_lesion = null;
    
    // Filtros específicos de cumplimiento
    public $supervisor_id = '';
    public $cumplimiento_minimo = '';
    
    public $datos = null;
    public $mostrarResultados = false;

    public function mount()
    {
        $this->fecha_inicio = now()->subMonth()->format('Y-m-d');
        $this->fecha_fin = now()->format('Y-m-d');
    }

    public function generarReporte()
    {
        $servicioReportes = new ServicioReportes();
        $filtros = $this->obtenerFiltros();
        
        switch ($this->tipoReporte) {
            case 'pacientes':
                $this->datos = $servicioReportes->reportePacientes($filtros);
                break;
            case 'caidas':
                $this->datos = $servicioReportes->reporteCaidas($filtros);
                break;
            case 'cumplimiento':
                $this->datos = $servicioReportes->reporteCumplimiento($filtros);
                break;
            case 'estadistico':
                $this->datos = $servicioReportes->reporteEstadistico($filtros);
                break;
        }
        
        $this->mostrarResultados = true;
    }

    public function limpiarFiltros()
    {
        $this->reset(['fecha_inicio', 'fecha_fin', 'estado', 'tipo', 'nivel_riesgo', 
                      'turno', 'tipo_caida', 'con_lesion', 'supervisor_id', 'cumplimiento_minimo']);
        $this->fecha_inicio = now()->subMonth()->format('Y-m-d');
        $this->fecha_fin = now()->format('Y-m-d');
        $this->mostrarResultados = false;
    }

    private function obtenerFiltros()
    {
        return array_filter([
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'estado' => $this->estado,
            'tipo' => $this->tipo,
            'nivel_riesgo' => $this->nivel_riesgo,
            'turno' => $this->turno,
            'tipo_caida' => $this->tipo_caida,
            'con_lesion' => $this->con_lesion,
            'supervisor_id' => $this->supervisor_id,
            'cumplimiento_minimo' => $this->cumplimiento_minimo,
        ], function($value) {
            return $value !== '' && $value !== null;
        });
    }

    public function render()
    {
        $supervisores = User::where('rol', 'supervisora')->get();
        
        return view('livewire.generador-reportes', [
            'supervisores' => $supervisores,
        ]);
    }
}

<?php

namespace App\Livewire;

use App\Models\Admision;
use App\Models\SeguimientoDiario;
use App\Models\ListaCotejo;
use App\Models\ItemListaCotejo;
use App\Services\ServicioRecomendacionAcciones;
use Livewire\Component;

class CotejoSupervisor extends Component
{
    public $admision;
    public $seguimientoDiario;
    public $accionesRecomendadas;
    public $accionesAplicadas = [];
    public $observaciones = [];
    public $fecha_verificacion;

    protected $servicioAcciones;

    public function boot(ServicioRecomendacionAcciones $servicioAcciones)
    {
        $this->servicioAcciones = $servicioAcciones;
    }

    public function mount($seguimientoId)
    {
        $this->seguimientoDiario = SeguimientoDiario::with('admision.paciente')->findOrFail($seguimientoId);
        $this->admision = $this->seguimientoDiario->admision;
        $this->fecha_verificacion = now()->format('Y-m-d');

        // Obtener la valoración inicial para conocer el nivel de riesgo
        $valoracionInicial = $this->admision->valoracionInicial();
        
        if ($valoracionInicial) {
            $nivelRiesgo = $valoracionInicial->nivelRiesgo;
            $this->accionesRecomendadas = $this->servicioAcciones->obtenerAccionesRecomendadas($nivelRiesgo);
        }
    }

    public function guardar()
    {
        $this->validate([
            'fecha_verificacion' => 'required|date',
        ]);

        // Contar acciones aplicadas
        $totalAcciones = $this->accionesRecomendadas->count();
        $accionesAplicadasCount = count(array_filter($this->accionesAplicadas));
        
        // Calcular porcentaje
        $porcentaje = $this->servicioAcciones->calcularPorcentajeCumplimiento(
            $accionesAplicadasCount,
            $totalAcciones
        );

        // Crear lista de cotejo
        $listaCotejo = ListaCotejo::create([
            'admision_id' => $this->admision->id,
            'seguimiento_diario_id' => $this->seguimientoDiario->id,
            'user_id' => auth()->id(),
            'fecha_verificacion' => $this->fecha_verificacion,
            'porcentaje_cumplimiento' => $porcentaje,
        ]);

        // Guardar items
        foreach ($this->accionesRecomendadas as $accion) {
            ItemListaCotejo::create([
                'lista_cotejo_id' => $listaCotejo->id,
                'accion_recomendada_id' => $accion->id,
                'aplicada' => isset($this->accionesAplicadas[$accion->id]) && $this->accionesAplicadas[$accion->id],
                'observacion' => $this->observaciones[$accion->id] ?? null,
            ]);
        }

        session()->flash('success', 'Lista de cotejo guardada exitosamente. Cumplimiento: ' . $porcentaje . '%');
        
        return redirect()->route('paciente.dashboard', ['admision' => $this->admision->id]);
    }

    public function render()
    {
        return view('livewire.cotejo-supervisor');
    }
}

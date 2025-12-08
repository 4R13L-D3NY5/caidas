<?php

namespace App\Livewire;

use App\Models\Admision;
use App\Models\SeguimientoDiario;
use Livewire\Component;

class SeguimientoDiarioForm extends Component
{
    public $admisionId;
    public $admision;
    public $tipoAdmision; // 'caida' o 'ulcera'
    
    // Campos comunes
    public $fecha;
    public $turno = '';
    
    // Campos para caídas
    public $hubo_caida = false;
    public $hora_caida = '';
    public $lugar = '';
    public $tipo_caida = '';
    public $hubo_lesion = false;
    public $descripcion_lesion = '';
    public $acciones_tomadas = [];
    public $observacion = '';
    
    // Campos para úlceras
    public $hubo_ulcera = false;
    public $estado_ulcera = '';
    public $presencia_necrosis = '';
    public $descripcion_ulcera = '';
    public $ubicacion_ulcera = '';
    public $observaciones_ulcera = '';
    
    public $estadosUlcera = [
        'Estado I' => 'Eritema en piel íntegra',
        'Estado II' => 'Pérdida parcial del espesor cutáneo (epidermis/dermis). Abrasión, flictena o úlcera superficial',
        'Estado III' => 'Pérdida total del espesor cutáneo con afectación de tejido subcutáneo. Puede haber cavidad, socavamiento y tejido de granulación',
        'Estado IV' => 'Pérdida total del espesor con exposición de músculo, hueso o estructuras de soporte. Frecuenta presencia de necrosis',
        'No clasificable' => 'Profundidad no determinable por presencia de esfacelos o escara que cubren la base de la lesión',
        'Lesión de tejido profundo' => 'Piel íntegra o con flictena hemática, color morado/borgoña'
    ];

    public function mount($admisionId)
    {
        $this->admisionId = $admisionId;
        $this->admision = Admision::with('paciente')->findOrFail($admisionId);
        $this->tipoAdmision = $this->admision->tipo;
        $this->fecha = now()->format('Y-m-d');
    }

    public function guardar()
    {
        if ($this->tipoAdmision === 'caida') {
            $this->guardarSeguimientoCaida();
        } else {
            $this->guardarSeguimientoUlcera();
        }
    }

    private function guardarSeguimientoCaida()
    {
        $rules = [
            'fecha' => 'required|date',
            'turno' => 'required|string',
            'hubo_caida' => 'required|boolean',
        ];

        if ($this->hubo_caida) {
            $rules = array_merge($rules, [
                'hora_caida' => 'required',
                'lugar' => 'required|string',
                'tipo_caida' => 'required|string',
                'hubo_lesion' => 'required|boolean',
            ]);

            if ($this->hubo_lesion) {
                $rules['descripcion_lesion'] = 'required|string';
            }
        }

        $this->validate($rules);

        SeguimientoDiario::create([
            'admision_id' => $this->admisionId,
            'fecha' => $this->fecha,
            'turno' => $this->turno,
            'hubo_caida' => $this->hubo_caida,
            'hora_caida' => $this->hubo_caida ? $this->hora_caida : null,
            'lugar' => $this->hubo_caida ? $this->lugar : null,
            'tipo_caida' => $this->hubo_caida ? $this->tipo_caida : null,
            'hubo_lesion' => $this->hubo_caida ? $this->hubo_lesion : null,
            'descripcion_lesion' => ($this->hubo_caida && $this->hubo_lesion) ? $this->descripcion_lesion : null,
            'acciones_tomadas' => $this->hubo_caida ? json_encode($this->acciones_tomadas) : null,
            'observacion' => $this->hubo_caida ? $this->observacion : null,
        ]);

        session()->flash('success', 'Seguimiento diario registrado exitosamente.');
        return redirect()->route('paciente.dashboard', $this->admisionId);
    }

    private function guardarSeguimientoUlcera()
    {
        $rules = [
            'fecha' => 'required|date',
            'turno' => 'required|string',
            'hubo_ulcera' => 'required|boolean',
        ];

        if ($this->hubo_ulcera) {
            $rules = array_merge($rules, [
                'estado_ulcera' => 'required|string',
                'descripcion_ulcera' => 'required|string',
                'ubicacion_ulcera' => 'required|string',
            ]);
        }

        $this->validate($rules);

        SeguimientoDiario::create([
            'admision_id' => $this->admisionId,
            'fecha' => $this->fecha,
            'turno' => $this->turno,
            'hubo_caida' => false,
            'hubo_ulcera' => $this->hubo_ulcera,
            'estado_ulcera' => $this->hubo_ulcera ? $this->estado_ulcera : null,
            // 'presencia_necrosis' => null, // Ya no se usa
            'descripcion_ulcera' => $this->hubo_ulcera ? $this->descripcion_ulcera : null,
            'ubicacion_ulcera' => $this->hubo_ulcera ? $this->ubicacion_ulcera : null,
            'observaciones_ulcera' => $this->hubo_ulcera ? $this->observaciones_ulcera : null,
        ]);

        session()->flash('success', 'Seguimiento diario de úlceras registrado exitosamente.');
        return redirect()->route('paciente.dashboard', $this->admisionId);
    }

    public function render()
    {
        return view('livewire.seguimiento-diario-form');
    }
}

<?php

namespace App\Livewire;

use App\Models\Admision;
use App\Models\SeguimientoDiario;
use Livewire\Component;

class ChequeoDiario extends Component
{
    public $admision;
    public $fecha;
    public $turno;
    public $hubo_caida = false;
    
    // Campos adicionales si hubo caída
    public $hora_caida;
    public $lugar;
    public $tipo_caida;
    public $hubo_lesion = false;
    public $descripcion_lesion;
    public $acciones_tomadas = [];
    public $observacion;

    public $opcionesLugar = ['Cama', 'Baño', 'Pasillo', 'Otro'];
    public $opcionesTipoCaida = [
        'Caída propia altura',
        'Desde cama',
        'Pérdida de equilibrio',
        'Tropiezo'
    ];
    public $opcionesAcciones = [
        'Notificación a médico',
        'Notificación a supervisora',
        'Notificación a familiar',
        'Medidas correctivas inmediatas',
        'Observación continua'
    ];

    public function mount($admisionId)
    {
        $this->admision = Admision::with('paciente')->findOrFail($admisionId);
        $this->fecha = now()->format('Y-m-d');
    }

    public function guardar()
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

        $data = [
            'admision_id' => $this->admision->id,
            'fecha' => $this->fecha,
            'turno' => $this->turno,
            'hubo_caida' => $this->hubo_caida,
        ];

        if ($this->hubo_caida) {
            $data = array_merge($data, [
                'hora_caida' => $this->hora_caida,
                'lugar' => $this->lugar,
                'tipo_caida' => $this->tipo_caida,
                'hubo_lesion' => $this->hubo_lesion,
                'descripcion_lesion' => $this->hubo_lesion ? $this->descripcion_lesion : null,
                'acciones_tomadas' => $this->acciones_tomadas,
                'observacion' => $this->observacion,
            ]);
        }

        SeguimientoDiario::create($data);

        session()->flash('success', 'Seguimiento diario registrado exitosamente');
        
        return redirect()->route('paciente.dashboard', ['admision' => $this->admision->id]);
    }

    public function render()
    {
        return view('livewire.chequeo-diario');
    }
}

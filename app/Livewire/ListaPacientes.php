<?php

namespace App\Livewire;

use App\Models\Admision;
use Livewire\Component;

class ListaPacientes extends Component
{
    public $tabActiva = 'activos';

    public function render()
    {
        $pacientesActivos = Admision::with(['paciente', 'valoraciones.nivelRiesgo'])
            ->where('estado', 'activo')
            ->orderBy('fecha_valoracion', 'desc')
            ->get();

        $pacientesAlta = Admision::with(['paciente', 'valoraciones.nivelRiesgo'])
            ->where('estado', 'alta')
            ->orderBy('fecha_alta', 'desc')
            ->get();

        return view('livewire.lista-pacientes', [
            'pacientesActivos' => $pacientesActivos,
            'pacientesAlta' => $pacientesAlta,
        ]);
    }
}

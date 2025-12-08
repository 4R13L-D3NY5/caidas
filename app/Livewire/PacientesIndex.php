<?php

namespace App\Livewire;

use App\Models\Paciente;
use Livewire\Component;
use Livewire\WithPagination;

class PacientesIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $pacienteIdEditar = null;
    
    // Datos de edición
    public $nombre = '';
    public $matricula = '';
    public $fecha_nacimiento = '';
    
    public $mostrarModal = false;

    public function render()
    {
        $pacientes = Paciente::where(function($query) {
                $query->where('nombre', 'like', '%' . $this->search . '%')
                      ->orWhere('matricula', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.pacientes.index', [
            'pacientes' => $pacientes
        ])->layout('layouts.app');
    }

    public function editar($id)
    {
        $paciente = Paciente::findOrFail($id);
        $this->pacienteIdEditar = $paciente->id;
        $this->nombre = $paciente->nombre;
        $this->matricula = $paciente->matricula;
        $this->fecha_nacimiento = $paciente->fecha_nacimiento ? $paciente->fecha_nacimiento->format('Y-m-d') : '';
        $this->mostrarModal = true;
    }

    public function actualizar()
    {
        $this->validate([
            'nombre' => 'required|string|max:255',
            'matricula' => 'required|string|max:255|unique:pacientes,matricula,' . $this->pacienteIdEditar,
            'fecha_nacimiento' => 'required|date|before:today',
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'matricula.required' => 'La matrícula es obligatoria',
            'matricula.unique' => 'Esta matrícula ya está en uso',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria',
            'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser anterior a hoy',
        ]);

        $paciente = Paciente::findOrFail($this->pacienteIdEditar);
        $paciente->update([
            'nombre' => $this->nombre,
            'matricula' => $this->matricula,
            'fecha_nacimiento' => $this->fecha_nacimiento,
        ]);

        $this->mostrarModal = false;
        $this->reset(['pacienteIdEditar', 'nombre', 'matricula', 'fecha_nacimiento']);
        session()->flash('success', 'Paciente actualizado correctamente');
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
        $this->reset(['pacienteIdEditar', 'nombre', 'matricula', 'fecha_nacimiento']);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}

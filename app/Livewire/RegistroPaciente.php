<?php

namespace App\Livewire;

use App\Models\Paciente;
use App\Models\Admision;
use App\Models\Escala;
use Livewire\Component;

class RegistroPaciente extends Component
{
    public $matricula = '';
    public $pacienteEncontrado = null;
    public $mostrarFormulario = false;
    
    // Datos del paciente
    public $nombre = '';
    public $fecha_nacimiento = '';
    
    // Datos de admisión
    public $tipo = 'caida';
    public $turno = '';
    public $fecha_valoracion = '';
    public $diagnostico_inicial = '';

    public function mount()
    {
        $this->fecha_valoracion = now()->format('Y-m-d');
    }

    public function buscarPaciente()
    {
        $this->validate([
            'matricula' => 'required|string|max:255',
        ], [
            'matricula.required' => 'La matrícula es obligatoria',
        ]);

        $paciente = Paciente::where('matricula', $this->matricula)->first();

        if ($paciente) {
            // Paciente encontrado
            $this->pacienteEncontrado = $paciente;
            $this->nombre = $paciente->nombre;
            $this->fecha_nacimiento = $paciente->fecha_nacimiento->format('Y-m-d');
            $this->mostrarFormulario = true;
        } else {
            // Paciente no encontrado, mostrar formulario completo
            $this->pacienteEncontrado = null;
            $this->nombre = '';
            $this->fecha_nacimiento = '';
            $this->mostrarFormulario = true;
        }
    }

    public function guardar()
    {
        $rules = [
            'matricula' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date|before:today',
            'tipo' => 'required|in:caida,ulcera',
            'turno' => 'required|string',
            'fecha_valoracion' => 'required|date',
            'diagnostico_inicial' => 'required|string',
        ];

        // Si es un paciente nuevo, validar que la matrícula sea única
        if (!$this->pacienteEncontrado) {
            $rules['matricula'] .= '|unique:pacientes,matricula';
        }

        $this->validate($rules, [
            'nombre.required' => 'El nombre es obligatorio',
            'matricula.required' => 'La matrícula es obligatoria',
            'matricula.unique' => 'Esta matrícula ya está registrada',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria',
            'fecha_nacimiento.date' => 'La fecha de nacimiento debe ser una fecha válida',
            'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser anterior a hoy',
            'tipo.required' => 'Debe seleccionar el tipo de admisión',
            'turno.required' => 'El turno es obligatorio',
            'fecha_valoracion.required' => 'La fecha de valoración es obligatoria',
            'diagnostico_inicial.required' => 'El diagnóstico inicial es obligatorio',
        ]);

        // Crear o actualizar paciente
        if ($this->pacienteEncontrado) {
            $paciente = $this->pacienteEncontrado;
            
            // Verificar si ya tiene una admisión activa del mismo tipo
            $admisionActiva = $paciente->admisiones()
                ->where('tipo', $this->tipo)
                ->where('estado', 'activo')
                ->first();
            
            if ($admisionActiva) {
                session()->flash('error', 'El paciente ya tiene una admisión activa de tipo ' . ($this->tipo === 'caida' ? 'Caídas' : 'Úlceras por Presión') . '. Debe dar de alta al paciente antes de crear una nueva admisión del mismo tipo.');
                return;
            }
            
            // Actualizar datos si han cambiado
            $paciente->update([
                'nombre' => $this->nombre,
                'fecha_nacimiento' => $this->fecha_nacimiento,
            ]);
        } else {
            $paciente = Paciente::create([
                'nombre' => $this->nombre,
                'matricula' => $this->matricula,
                'fecha_nacimiento' => $this->fecha_nacimiento,
            ]);
        }

        // Crear admisión
        $admision = Admision::create([
            'paciente_id' => $paciente->id,
            'tipo' => $this->tipo,
            'turno' => $this->turno,
            'fecha_valoracion' => $this->fecha_valoracion,
            'diagnostico_inicial' => $this->diagnostico_inicial,
        ]);

        session()->flash('success', $this->pacienteEncontrado ? 'Nueva admisión registrada exitosamente' : 'Paciente registrado exitosamente');
        
        // Redirigir a la valoración inicial
        return redirect()->route('valoracion.inicial', ['admision' => $admision->id]);
    }

    public function cancelar()
    {
        $this->reset();
        $this->fecha_valoracion = now()->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.registro-paciente');
    }
}

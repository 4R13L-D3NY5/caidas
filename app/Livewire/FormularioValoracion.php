<?php

namespace App\Livewire;

use App\Models\Admision;
use App\Models\Valoracion;
use App\Models\RespuestaValoracion;
use App\Models\Escala;
use App\Services\ServicioCalculoRiesgo;
use App\Services\ServicioRecomendacionAcciones;
use Livewire\Component;

class FormularioValoracion extends Component
{
    public $admision;
    public $escala;
    public $items;
    public $respuestas = [];
    public $tipoValoracion = 'inicial'; // inicial o alta

    protected $servicioRiesgo;
    protected $servicioAcciones;

    public function boot(ServicioCalculoRiesgo $servicioRiesgo, ServicioRecomendacionAcciones $servicioAcciones)
    {
        $this->servicioRiesgo = $servicioRiesgo;
        $this->servicioAcciones = $servicioAcciones;
    }

    public function mount($admisionId, $tipo = 'inicial')
    {
        $this->admision = Admision::with('paciente')->findOrFail($admisionId);
        $this->tipoValoracion = $tipo;
        
        // Cargar la escala según el tipo de admisión
        $this->escala = Escala::with(['items.opciones'])
            ->where('tipo', $this->admision->tipo)
            ->first();
        
        $this->items = $this->escala->items;
    }

    public function guardarValoracion()
    {
        // Validar que todas las preguntas tengan respuesta
        $this->validate([
            'respuestas' => 'required|array|min:' . $this->items->count(),
        ], [
            'respuestas.required' => 'Debe responder todas las preguntas',
            'respuestas.min' => 'Debe responder todas las preguntas',
        ]);

        // Calcular puntaje total
        $puntajeTotal = 0;
        $respuestasDetalle = [];

        foreach ($this->respuestas as $itemId => $opcionId) {
            $opcion = \App\Models\OpcionEscala::find($opcionId);
            $puntajeTotal += $opcion->puntaje;
            
            $respuestasDetalle[] = [
                'item_escala_id' => $itemId,
                'opcion_escala_id' => $opcionId,
            ];
        }

        // Determinar nivel de riesgo
        $nivelRiesgo = $this->servicioRiesgo->calcularNivelRiesgo($puntajeTotal, $this->admision->tipo);

        // Crear valoración
        $valoracion = Valoracion::create([
            'admision_id' => $this->admision->id,
            'tipo_valoracion' => $this->tipoValoracion,
            'puntaje_total' => $puntajeTotal,
            'nivel_riesgo_id' => $nivelRiesgo->id,
        ]);

        // Guardar respuestas
        foreach ($respuestasDetalle as $respuesta) {
            RespuestaValoracion::create([
                'valoracion_id' => $valoracion->id,
                'item_escala_id' => $respuesta['item_escala_id'],
                'opcion_escala_id' => $respuesta['opcion_escala_id'],
            ]);
        }

        // Si es valoración de alta, actualizar el estado de la admisión
        if ($this->tipoValoracion === 'alta') {
            $this->admision->update([
                'estado' => 'alta',
                'fecha_alta' => now(),
            ]);
        }

        session()->flash('success', 'Valoración guardada exitosamente');

        // Redirigir al dashboard del paciente
        return redirect()->route('paciente.dashboard', ['admision' => $this->admision->id]);
    }

    public function render()
    {
        return view('livewire.formulario-valoracion');
    }
}

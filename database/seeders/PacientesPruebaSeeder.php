<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Paciente;
use App\Models\Admision;
use App\Models\Valoracion;
use App\Models\RespuestaValoracion;
use App\Models\SeguimientoDiario;
use App\Models\ListaCotejo;
use App\Models\ItemListaCotejo;
use App\Models\NivelRiesgo;
use App\Models\Escala;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PacientesPruebaSeeder extends Seeder
{
    public function run(): void
    {
        $supervisora = User::where('email', 'supervisora@caidas.com')->first();
        $enfermera = User::where('email', 'enfermera@caidas.com')->first();

        // Obtener escalas
        $escalaCaidas = Escala::where('tipo', 'caida')->first();
        $escalaUlceras = Escala::where('tipo', 'ulcera')->first();

        // Pacientes Activos (10)
        $this->crearPacientesActivos($supervisora, $enfermera, $escalaCaidas, $escalaUlceras);

        // Pacientes de Alta (5)
        $this->crearPacientesAlta($supervisora, $enfermera, $escalaCaidas, $escalaUlceras);
    }

    private function crearPacientesActivos($supervisora, $enfermera, $escalaCaidas, $escalaUlceras)
    {
        $pacientesData = [
            ['nombre' => 'Juan Pérez García', 'matricula' => 'PAC-001', 'fecha_nacimiento' => '1950-03-15', 'tipo' => 'caida', 'puntaje' => 7],
            ['nombre' => 'María González López', 'matricula' => 'PAC-002', 'fecha_nacimiento' => '1945-07-22', 'tipo' => 'caida', 'puntaje' => 12],
            ['nombre' => 'Carlos Rodríguez Sánchez', 'matricula' => 'PAC-003', 'fecha_nacimiento' => '1955-11-08', 'tipo' => 'ulcera', 'puntaje' => 15],
            ['nombre' => 'Ana Martínez Fernández', 'matricula' => 'PAC-004', 'fecha_nacimiento' => '1948-02-14', 'tipo' => 'caida', 'puntaje' => 5],
            ['nombre' => 'Luis Hernández Ruiz', 'matricula' => 'PAC-005', 'fecha_nacimiento' => '1952-09-30', 'tipo' => 'ulcera', 'puntaje' => 18],
            ['nombre' => 'Carmen Díaz Torres', 'matricula' => 'PAC-006', 'fecha_nacimiento' => '1943-05-19', 'tipo' => 'caida', 'puntaje' => 9],
            ['nombre' => 'José López Ramírez', 'matricula' => 'PAC-007', 'fecha_nacimiento' => '1958-12-03', 'tipo' => 'caida', 'puntaje' => 6],
            ['nombre' => 'Rosa García Moreno', 'matricula' => 'PAC-008', 'fecha_nacimiento' => '1946-08-25', 'tipo' => 'ulcera', 'puntaje' => 12],
            ['nombre' => 'Francisco Sánchez Ortiz', 'matricula' => 'PAC-009', 'fecha_nacimiento' => '1951-04-17', 'tipo' => 'caida', 'puntaje' => 11],
            ['nombre' => 'Isabel Romero Castro', 'matricula' => 'PAC-010', 'fecha_nacimiento' => '1949-10-28', 'tipo' => 'ulcera', 'puntaje' => 14],
        ];

        foreach ($pacientesData as $data) {
            $paciente = Paciente::create([
                'nombre' => $data['nombre'],
                'matricula' => $data['matricula'],
                'fecha_nacimiento' => $data['fecha_nacimiento'],
            ]);

            $escala = $data['tipo'] === 'caida' ? $escalaCaidas : $escalaUlceras;
            $fechaIngreso = now()->subDays(rand(5, 30));

            $admision = Admision::create([
                'paciente_id' => $paciente->id,
                'tipo' => $data['tipo'],
                'turno' => ['Mañana', 'Tarde', 'Noche 1'][rand(0, 2)],
                'fecha_valoracion' => $fechaIngreso,
                'diagnostico_inicial' => $this->generarDiagnostico($data['tipo']),
                'estado' => 'activo',
            ]);

            // Crear valoración inicial
            $nivelRiesgo = $this->obtenerNivelRiesgo($escala, $data['puntaje']);
            $valoracion = Valoracion::create([
                'admision_id' => $admision->id,
                'tipo_valoracion' => 'inicial',
                'puntaje_total' => $data['puntaje'],
                'nivel_riesgo_id' => $nivelRiesgo->id,
            ]);

            // Crear respuestas de valoración
            $this->crearRespuestasValoracion($valoracion, $escala, $data['puntaje']);

            // Crear seguimientos diarios (entre 3 y 10)
            $numSeguimientos = rand(3, 10);
            for ($i = 0; $i < $numSeguimientos; $i++) {
                $fechaSeguimiento = $fechaIngreso->copy()->addDays($i + 1);
                if ($fechaSeguimiento->isFuture()) break;

                $huboCaida = $data['tipo'] === 'caida' && rand(1, 100) <= 20; // 20% probabilidad de caída

                $seguimiento = SeguimientoDiario::create([
                    'admision_id' => $admision->id,
                    'fecha' => $fechaSeguimiento,
                    'turno' => ['Mañana', 'Tarde', 'Noche 1', 'Noche 2', 'Noche 3'][rand(0, 4)],
                    'hubo_caida' => $huboCaida,
                    'hora_caida' => $huboCaida ? sprintf('%02d:%02d', rand(0, 23), rand(0, 59)) : null,
                    'lugar' => $huboCaida ? ['Cama', 'Baño', 'Pasillo', 'Habitación'][rand(0, 3)] : null,
                    'tipo_caida' => $huboCaida ? ['Caída propia altura', 'Desde cama', 'Desde silla'][rand(0, 2)] : null,
                    'hubo_lesion' => $huboCaida ? (rand(1, 100) <= 30) : false,
                    'descripcion_lesion' => $huboCaida && rand(1, 100) <= 30 ? 'Contusión leve en brazo derecho' : null,
                    'acciones_tomadas' => $huboCaida ? ['Asistencia inmediata', 'Evaluación médica', 'Registro de incidente'] : null,
                    'observacion' => rand(1, 100) <= 40 ? 'Paciente estable durante el turno' : null,
                ]);

                // Crear lista de cotejo (70% de probabilidad)
                if (rand(1, 100) <= 70) {
                    $porcentajeCumplimiento = rand(50, 100);
                    $cotejo = ListaCotejo::create([
                        'admision_id' => $admision->id,
                        'seguimiento_diario_id' => $seguimiento->id,
                        'user_id' => $supervisora->id,
                        'fecha_verificacion' => $fechaSeguimiento->copy()->addHours(rand(1, 6)),
                        'porcentaje_cumplimiento' => $porcentajeCumplimiento,
                        'observaciones' => $porcentajeCumplimiento < 70 ? 'Mejorar cumplimiento de protocolos' : null,
                    ]);

                    // Crear items de cotejo
                    $acciones = $nivelRiesgo->accionesRecomendadas;
                    foreach ($acciones as $accion) {
                        ItemListaCotejo::create([
                            'lista_cotejo_id' => $cotejo->id,
                            'accion_recomendada_id' => $accion->id,
                            'aplicada' => rand(1, 100) <= $porcentajeCumplimiento,
                        ]);
                    }
                }
            }
        }
    }

    private function crearPacientesAlta($supervisora, $enfermera, $escalaCaidas, $escalaUlceras)
    {
        $pacientesData = [
            ['nombre' => 'Pedro Jiménez Vega', 'matricula' => 'PAC-011', 'fecha_nacimiento' => '1947-06-12', 'tipo' => 'caida', 'puntaje_inicial' => 10, 'puntaje_final' => 4],
            ['nombre' => 'Laura Navarro Gil', 'matricula' => 'PAC-012', 'fecha_nacimiento' => '1953-01-20', 'tipo' => 'ulcera', 'puntaje_inicial' => 16, 'puntaje_final' => 8],
            ['nombre' => 'Miguel Vargas Ramos', 'matricula' => 'PAC-013', 'fecha_nacimiento' => '1944-09-05', 'tipo' => 'caida', 'puntaje_inicial' => 8, 'puntaje_final' => 3],
            ['nombre' => 'Teresa Molina Cruz', 'matricula' => 'PAC-014', 'fecha_nacimiento' => '1950-11-18', 'tipo' => 'ulcera', 'puntaje_inicial' => 14, 'puntaje_final' => 6],
            ['nombre' => 'Antonio Serrano Blanco', 'matricula' => 'PAC-015', 'fecha_nacimiento' => '1956-03-27', 'tipo' => 'caida', 'puntaje_inicial' => 9, 'puntaje_final' => 5],
        ];

        foreach ($pacientesData as $data) {
            $paciente = Paciente::create([
                'nombre' => $data['nombre'],
                'matricula' => $data['matricula'],
                'fecha_nacimiento' => $data['fecha_nacimiento'],
            ]);

            $escala = $data['tipo'] === 'caida' ? $escalaCaidas : $escalaUlceras;
            $fechaIngreso = now()->subDays(rand(40, 90));
            $fechaAlta = now()->subDays(rand(1, 10));

            $admision = Admision::create([
                'paciente_id' => $paciente->id,
                'tipo' => $data['tipo'],
                'turno' => ['Mañana', 'Tarde', 'Noche 1'][rand(0, 2)],
                'fecha_valoracion' => $fechaIngreso,
                'diagnostico_inicial' => $this->generarDiagnostico($data['tipo']),
                'diagnostico_final' => 'Mejoría significativa. Alta por cumplimiento de objetivos terapéuticos.',
                'estado' => 'alta',
                'fecha_alta' => $fechaAlta,
            ]);

            // Valoración inicial
            $nivelRiesgoInicial = $this->obtenerNivelRiesgo($escala, $data['puntaje_inicial']);
            $valoracionInicial = Valoracion::create([
                'admision_id' => $admision->id,
                'tipo_valoracion' => 'inicial',
                'puntaje_total' => $data['puntaje_inicial'],
                'nivel_riesgo_id' => $nivelRiesgoInicial->id,
            ]);
            $this->crearRespuestasValoracion($valoracionInicial, $escala, $data['puntaje_inicial']);

            // Valoración de alta
            $nivelRiesgoFinal = $this->obtenerNivelRiesgo($escala, $data['puntaje_final']);
            $valoracionAlta = Valoracion::create([
                'admision_id' => $admision->id,
                'tipo_valoracion' => 'alta',
                'puntaje_total' => $data['puntaje_final'],
                'nivel_riesgo_id' => $nivelRiesgoFinal->id,
            ]);
            $this->crearRespuestasValoracion($valoracionAlta, $escala, $data['puntaje_final']);

            // Crear seguimientos diarios (entre 10 y 20)
            $diasInternacion = $fechaIngreso->diffInDays($fechaAlta);
            $numSeguimientos = min($diasInternacion, rand(10, 20));
            
            for ($i = 0; $i < $numSeguimientos; $i++) {
                $fechaSeguimiento = $fechaIngreso->copy()->addDays($i + 1);
                if ($fechaSeguimiento->isAfter($fechaAlta)) break;

                $huboCaida = $data['tipo'] === 'caida' && rand(1, 100) <= 15;

                $seguimiento = SeguimientoDiario::create([
                    'admision_id' => $admision->id,
                    'fecha' => $fechaSeguimiento,
                    'turno' => ['Mañana', 'Tarde', 'Noche 1', 'Noche 2', 'Noche 3'][rand(0, 4)],
                    'hubo_caida' => $huboCaida,
                    'hora_caida' => $huboCaida ? sprintf('%02d:%02d', rand(0, 23), rand(0, 59)) : null,
                    'lugar' => $huboCaida ? ['Cama', 'Baño', 'Pasillo'][rand(0, 2)] : null,
                    'tipo_caida' => $huboCaida ? ['Caída propia altura', 'Desde cama'][rand(0, 1)] : null,
                    'hubo_lesion' => $huboCaida ? (rand(1, 100) <= 20) : false,
                    'observacion' => rand(1, 100) <= 50 ? 'Evolución favorable' : null,
                ]);

                // Crear lista de cotejo (80% de probabilidad para pacientes de alta)
                if (rand(1, 100) <= 80) {
                    $porcentajeCumplimiento = rand(70, 100); // Mayor cumplimiento en pacientes de alta
                    $cotejo = ListaCotejo::create([
                        'admision_id' => $admision->id,
                        'seguimiento_diario_id' => $seguimiento->id,
                        'user_id' => $supervisora->id,
                        'fecha_verificacion' => $fechaSeguimiento->copy()->addHours(rand(1, 6)),
                        'porcentaje_cumplimiento' => $porcentajeCumplimiento,
                    ]);

                    $acciones = $nivelRiesgoInicial->accionesRecomendadas;
                    foreach ($acciones as $accion) {
                        ItemListaCotejo::create([
                            'lista_cotejo_id' => $cotejo->id,
                            'accion_recomendada_id' => $accion->id,
                            'aplicada' => rand(1, 100) <= $porcentajeCumplimiento,
                        ]);
                    }
                }
            }
        }
    }

    private function obtenerNivelRiesgo($escala, $puntaje)
    {
        return NivelRiesgo::where('escala_id', $escala->id)
            ->where('puntaje_min', '<=', $puntaje)
            ->where('puntaje_max', '>=', $puntaje)
            ->first();
    }

    private function crearRespuestasValoracion($valoracion, $escala, $puntajeObjetivo)
    {
        $items = $escala->items;
        $puntajeAcumulado = 0;

        foreach ($items as $item) {
            $opciones = $item->opciones->sortBy('puntaje');
            $opcionSeleccionada = $opciones->first();

            // Distribuir puntaje de manera realista
            foreach ($opciones as $opcion) {
                if ($puntajeAcumulado + $opcion->puntaje <= $puntajeObjetivo) {
                    $opcionSeleccionada = $opcion;
                }
            }

            RespuestaValoracion::create([
                'valoracion_id' => $valoracion->id,
                'item_escala_id' => $item->id,
                'opcion_escala_id' => $opcionSeleccionada->id,
            ]);

            $puntajeAcumulado += $opcionSeleccionada->puntaje;
        }
    }

    private function generarDiagnostico($tipo)
    {
        $diagnosticosCaidas = [
            'Paciente con antecedentes de caídas recurrentes. Marcha inestable.',
            'Riesgo elevado de caídas por deterioro de la movilidad y uso de medicación sedante.',
            'Paciente con debilidad muscular y alteración del equilibrio.',
            'Historia de caída reciente. Requiere vigilancia estrecha.',
        ];

        $diagnosticosUlceras = [
            'Paciente con movilidad reducida. Riesgo de úlceras por presión en zonas de apoyo.',
            'Inmovilización prolongada. Piel frágil con riesgo de lesiones.',
            'Estado nutricional comprometido. Alto riesgo de desarrollo de UPP.',
            'Paciente encamado con limitación para cambios posturales.',
        ];

        return $tipo === 'caida' 
            ? $diagnosticosCaidas[rand(0, count($diagnosticosCaidas) - 1)]
            : $diagnosticosUlceras[rand(0, count($diagnosticosUlceras) - 1)];
    }
}

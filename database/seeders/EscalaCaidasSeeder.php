<?php

namespace Database\Seeders;

use App\Models\Escala;
use App\Models\ItemEscala;
use App\Models\OpcionEscala;
use App\Models\NivelRiesgo;
use App\Models\AccionRecomendada;
use Illuminate\Database\Seeder;

class EscalaCaidasSeeder extends Seeder
{
    public function run(): void
    {
        // Crear la escala de caídas
        $escala = Escala::create([
            'nombre' => 'Escala de Valoración de Riesgo de Caídas',
            'tipo' => 'caida',
            'descripcion' => 'Evaluación del riesgo de caídas en pacientes hospitalizados',
        ]);

        // Ítem 1: Historial de caídas
        $item1 = ItemEscala::create([
            'escala_id' => $escala->id,
            'numero' => 1,
            'nombre' => 'Historial de caídas (últimos 6 meses)',
        ]);

        OpcionEscala::create(['item_escala_id' => $item1->id, 'criterio' => 'Ninguna caída', 'puntaje' => 0]);
        OpcionEscala::create(['item_escala_id' => $item1->id, 'criterio' => '1 o más caídas (o caída en esta hospitalización)', 'puntaje' => 2]);

        // Ítem 2: Edad
        $item2 = ItemEscala::create([
            'escala_id' => $escala->id,
            'numero' => 2,
            'nombre' => 'Edad',
        ]);

        OpcionEscala::create(['item_escala_id' => $item2->id, 'criterio' => '< 65 años', 'puntaje' => 0]);
        OpcionEscala::create(['item_escala_id' => $item2->id, 'criterio' => '65–79 años', 'puntaje' => 1]);
        OpcionEscala::create(['item_escala_id' => $item2->id, 'criterio' => '≥ 80 años', 'puntaje' => 2]);

        // Ítem 3: Estado cognitivo / conciencia
        $item3 = ItemEscala::create([
            'escala_id' => $escala->id,
            'numero' => 3,
            'nombre' => 'Estado cognitivo / conciencia',
        ]);

        OpcionEscala::create(['item_escala_id' => $item3->id, 'criterio' => 'Orientado, sigue indicaciones', 'puntaje' => 0]);
        OpcionEscala::create(['item_escala_id' => $item3->id, 'criterio' => 'Desorientado, confuso, agitado, olvida limitaciones', 'puntaje' => 2]);

        // Ítem 4: Marcha y movilidad
        $item4 = ItemEscala::create([
            'escala_id' => $escala->id,
            'numero' => 4,
            'nombre' => 'Marcha y movilidad',
        ]);

        OpcionEscala::create(['item_escala_id' => $item4->id, 'criterio' => 'Camina independiente o usa silla de ruedas sin intentos de levantarse solo', 'puntaje' => 0]);
        OpcionEscala::create(['item_escala_id' => $item4->id, 'criterio' => 'Requiere ayuda o apoyo para caminar (bastón, andador, persona)', 'puntaje' => 1]);
        OpcionEscala::create(['item_escala_id' => $item4->id, 'criterio' => 'Marcha inestable, tambaleante o se levanta solo pese a indicaciones', 'puntaje' => 2]);

        // Ítem 5: Medicamentos de riesgo
        $item5 = ItemEscala::create([
            'escala_id' => $escala->id,
            'numero' => 5,
            'nombre' => 'Medicamentos de riesgo',
            'descripcion' => 'Sedantes, hipnóticos, opioides, antihipertensivos, diuréticos, hipoglucemiantes, antidepresivos, anticonvulsivantes',
        ]);

        OpcionEscala::create(['item_escala_id' => $item5->id, 'criterio' => 'No recibe medicamentos de este tipo', 'puntaje' => 0]);
        OpcionEscala::create(['item_escala_id' => $item5->id, 'criterio' => '≥ 1 medicamento de riesgo', 'puntaje' => 1]);
        OpcionEscala::create(['item_escala_id' => $item5->id, 'criterio' => '≥ 3 medicamentos de riesgo', 'puntaje' => 2]);

        // Ítem 6: Dispositivos / terapia
        $item6 = ItemEscala::create([
            'escala_id' => $escala->id,
            'numero' => 6,
            'nombre' => 'Dispositivos / terapia',
        ]);

        OpcionEscala::create(['item_escala_id' => $item6->id, 'criterio' => 'Sin terapia IV, sin dispositivos invasivos', 'puntaje' => 0]);
        OpcionEscala::create(['item_escala_id' => $item6->id, 'criterio' => 'Con suero, catéter, sondas, yesos, órtesis, etc.', 'puntaje' => 1]);

        // Ítem 7: Eliminación
        $item7 = ItemEscala::create([
            'escala_id' => $escala->id,
            'numero' => 7,
            'nombre' => 'Eliminación (orina / heces)',
        ]);

        OpcionEscala::create(['item_escala_id' => $item7->id, 'criterio' => 'Continente, pide ayuda a tiempo', 'puntaje' => 0]);
        OpcionEscala::create(['item_escala_id' => $item7->id, 'criterio' => 'Urgencia miccional, incontinencia, frecuencia nocturna aumentada', 'puntaje' => 1]);

        // Ítem 8: Déficit sensorial
        $item8 = ItemEscala::create([
            'escala_id' => $escala->id,
            'numero' => 8,
            'nombre' => 'Déficit sensorial (visión / audición)',
        ]);

        OpcionEscala::create(['item_escala_id' => $item8->id, 'criterio' => 'Sin alteración relevante o usa ayudas (lentes/audífonos) correctamente', 'puntaje' => 0]);
        OpcionEscala::create(['item_escala_id' => $item8->id, 'criterio' => 'Problema visual o auditivo importante sin ayudas o no las utiliza', 'puntaje' => 1]);

        // Niveles de riesgo
        $nivelBajo = NivelRiesgo::create([
            'escala_id' => $escala->id,
            'nombre' => 'Riesgo Bajo',
            'puntaje_min' => 0,
            'puntaje_max' => 3,
            'color' => 'verde',
            'codigo_color' => '#22c55e',
        ]);

        $nivelModerado = NivelRiesgo::create([
            'escala_id' => $escala->id,
            'nombre' => 'Riesgo Moderado',
            'puntaje_min' => 4,
            'puntaje_max' => 7,
            'color' => 'amarillo',
            'codigo_color' => '#eab308',
        ]);

        $nivelAlto = NivelRiesgo::create([
            'escala_id' => $escala->id,
            'nombre' => 'Riesgo Alto',
            'puntaje_min' => 8,
            'puntaje_max' => 12,
            'color' => 'rojo',
            'codigo_color' => '#ef4444',
        ]);

        // Acciones recomendadas - Riesgo Bajo
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelBajo->id, 'descripcion' => 'Orientación al paciente', 'orden' => 1]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelBajo->id, 'descripcion' => 'Llamado al timbre visible', 'orden' => 2]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelBajo->id, 'descripcion' => 'Barandas elevadas laterales', 'orden' => 3]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelBajo->id, 'descripcion' => 'Suelo seco y despejado', 'orden' => 4]);

        // Acciones recomendadas - Riesgo Moderado (incluye las del bajo)
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelModerado->id, 'descripcion' => 'Identificación visible (pulsera amarilla / rótulo en Kardex)', 'orden' => 5]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelModerado->id, 'descripcion' => 'Supervisión en traslado y baño', 'orden' => 6]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelModerado->id, 'descripcion' => 'Mantener al alcance: agua, timbre, ropa', 'orden' => 7]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelModerado->id, 'descripcion' => 'Calzado antideslizante', 'orden' => 8]);

        // Acciones recomendadas - Riesgo Alto (incluye las del moderado y bajo)
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelAlto->id, 'descripcion' => 'Paciente cercano al puesto de enfermería', 'orden' => 9]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelAlto->id, 'descripcion' => 'Vigilancia frecuente (cada hora)', 'orden' => 10]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelAlto->id, 'descripcion' => 'Asistencia obligatoria en deambulación', 'orden' => 11]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelAlto->id, 'descripcion' => 'Barandas arriba x2', 'orden' => 12]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelAlto->id, 'descripcion' => 'Evaluar necesidad de cama baja', 'orden' => 13]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelAlto->id, 'descripcion' => 'Notificar a médico / supervisión', 'orden' => 14]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelAlto->id, 'descripcion' => 'Informar a la familia (consentimiento de inmovilización)', 'orden' => 15]);
    }
}

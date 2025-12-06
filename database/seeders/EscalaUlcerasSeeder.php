<?php

namespace Database\Seeders;

use App\Models\Escala;
use App\Models\ItemEscala;
use App\Models\OpcionEscala;
use App\Models\NivelRiesgo;
use App\Models\AccionRecomendada;
use Illuminate\Database\Seeder;

class EscalaUlcerasSeeder extends Seeder
{
    public function run(): void
    {
        // Crear la escala de úlceras
        $escala = Escala::create([
            'nombre' => 'Escala de Valoración del Riesgo de Úlceras por Presión (EVR-UPP)',
            'tipo' => 'ulcera',
            'descripcion' => 'Evaluación del riesgo de úlceras por presión',
        ]);

        // Ítem 1: Percepción sensorial
        $item1 = ItemEscala::create([
            'escala_id' => $escala->id,
            'numero' => 1,
            'nombre' => 'Percepción sensorial',
        ]);

        OpcionEscala::create(['item_escala_id' => $item1->id, 'criterio' => 'No responde a estímulos; inconsciente; anestesia total', 'puntaje' => 1]);
        OpcionEscala::create(['item_escala_id' => $item1->id, 'criterio' => 'Responde solo al dolor; confusión significativa', 'puntaje' => 2]);
        OpcionEscala::create(['item_escala_id' => $item1->id, 'criterio' => 'Responde a órdenes verbales; ligera limitación', 'puntaje' => 3]);
        OpcionEscala::create(['item_escala_id' => $item1->id, 'criterio' => 'Percibe y comunica molestias sin problemas', 'puntaje' => 4]);

        // Ítem 2: Humedad de la piel
        $item2 = ItemEscala::create([
            'escala_id' => $escala->id,
            'numero' => 2,
            'nombre' => 'Humedad de la piel',
        ]);

        OpcionEscala::create(['item_escala_id' => $item2->id, 'criterio' => 'Piel constantemente húmeda; incontinencia total', 'puntaje' => 1]);
        OpcionEscala::create(['item_escala_id' => $item2->id, 'criterio' => 'Muy húmeda; cambios de ropa frecuentes (≥3/día)', 'puntaje' => 2]);
        OpcionEscala::create(['item_escala_id' => $item2->id, 'criterio' => 'Ocasionalmente húmeda; cambios 1–2 veces/día', 'puntaje' => 3]);
        OpcionEscala::create(['item_escala_id' => $item2->id, 'criterio' => 'Piel seca; humedad mínima o ausente', 'puntaje' => 4]);

        // Ítem 3: Actividad física
        $item3 = ItemEscala::create([
            'escala_id' => $escala->id,
            'numero' => 3,
            'nombre' => 'Actividad física',
        ]);

        OpcionEscala::create(['item_escala_id' => $item3->id, 'criterio' => 'Postrado en cama; sin deambulación', 'puntaje' => 1]);
        OpcionEscala::create(['item_escala_id' => $item3->id, 'criterio' => 'Solo se mantiene sentado; no camina', 'puntaje' => 2]);
        OpcionEscala::create(['item_escala_id' => $item3->id, 'criterio' => 'Camina ocasionalmente distancias cortas', 'puntaje' => 3]);
        OpcionEscala::create(['item_escala_id' => $item3->id, 'criterio' => 'Camina frecuentemente, independiente', 'puntaje' => 4]);

        // Ítem 4: Movilidad
        $item4 = ItemEscala::create([
            'escala_id' => $escala->id,
            'numero' => 4,
            'nombre' => 'Movilidad',
        ]);

        OpcionEscala::create(['item_escala_id' => $item4->id, 'criterio' => 'Totalmente inmóvil; no cambia posición sin ayuda', 'puntaje' => 1]);
        OpcionEscala::create(['item_escala_id' => $item4->id, 'criterio' => 'Movilidad muy limitada; requiere asistencia frecuente', 'puntaje' => 2]);
        OpcionEscala::create(['item_escala_id' => $item4->id, 'criterio' => 'Movilidad ligeramente limitada; no alivia presión de forma adecuada', 'puntaje' => 3]);
        OpcionEscala::create(['item_escala_id' => $item4->id, 'criterio' => 'Movilidad completa; cambia posición espontáneamente', 'puntaje' => 4]);

        // Ítem 5: Nutrición
        $item5 = ItemEscala::create([
            'escala_id' => $escala->id,
            'numero' => 5,
            'nombre' => 'Nutrición',
        ]);

        OpcionEscala::create(['item_escala_id' => $item5->id, 'criterio' => 'Muy deficiente; ingesta mínima; ayuno; malnutrición evidente', 'puntaje' => 1]);
        OpcionEscala::create(['item_escala_id' => $item5->id, 'criterio' => 'Deficiente; come poco; suplementos parciales', 'puntaje' => 2]);
        OpcionEscala::create(['item_escala_id' => $item5->id, 'criterio' => 'Adecuada; ingiere la mayoría de alimentos', 'puntaje' => 3]);
        OpcionEscala::create(['item_escala_id' => $item5->id, 'criterio' => 'Excelente; alimentación completa y balanceada', 'puntaje' => 4]);

        // Ítem 6: Fricción y cizalla
        $item6 = ItemEscala::create([
            'escala_id' => $escala->id,
            'numero' => 6,
            'nombre' => 'Fricción y cizalla',
        ]);

        OpcionEscala::create(['item_escala_id' => $item6->id, 'criterio' => 'Problema severo; se desliza frecuentemente; lesiones visibles', 'puntaje' => 1]);
        OpcionEscala::create(['item_escala_id' => $item6->id, 'criterio' => 'Problema moderado; se desliza ocasionalmente; necesita ayuda', 'puntaje' => 2]);
        OpcionEscala::create(['item_escala_id' => $item6->id, 'criterio' => 'Problema leve; se moviliza con mínima fricción', 'puntaje' => 3]);
        OpcionEscala::create(['item_escala_id' => $item6->id, 'criterio' => 'Sin problema; control completo de movimientos', 'puntaje' => 4]);

        // Niveles de riesgo
        $nivelMuyAlto = NivelRiesgo::create([
            'escala_id' => $escala->id,
            'nombre' => 'Riesgo Muy Alto',
            'puntaje_min' => 6,
            'puntaje_max' => 12,
            'color' => 'rojo oscuro',
            'codigo_color' => '#991b1b',
        ]);

        $nivelAlto = NivelRiesgo::create([
            'escala_id' => $escala->id,
            'nombre' => 'Riesgo Alto',
            'puntaje_min' => 13,
            'puntaje_max' => 15,
            'color' => 'rojo',
            'codigo_color' => '#ef4444',
        ]);

        $nivelModerado = NivelRiesgo::create([
            'escala_id' => $escala->id,
            'nombre' => 'Riesgo Moderado',
            'puntaje_min' => 16,
            'puntaje_max' => 18,
            'color' => 'amarillo',
            'codigo_color' => '#eab308',
        ]);

        $nivelBajo = NivelRiesgo::create([
            'escala_id' => $escala->id,
            'nombre' => 'Riesgo Bajo',
            'puntaje_min' => 19,
            'puntaje_max' => 21,
            'color' => 'verde claro',
            'codigo_color' => '#84cc16',
        ]);

        $sinRiesgo = NivelRiesgo::create([
            'escala_id' => $escala->id,
            'nombre' => 'Sin Riesgo',
            'puntaje_min' => 22,
            'puntaje_max' => 24,
            'color' => 'verde',
            'codigo_color' => '#22c55e',
        ]);

        // Acciones recomendadas - Riesgo Muy Alto
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelMuyAlto->id, 'descripcion' => 'Realizar cambios posturales cada 2 horas estrictos', 'orden' => 1]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelMuyAlto->id, 'descripcion' => 'Utilizar colchón terapéutico o superficie especial de alivio de presión', 'orden' => 2]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelMuyAlto->id, 'descripcion' => 'Colocar almohadillas protectoras en talones, codos, sacro y prominencias óseas', 'orden' => 3]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelMuyAlto->id, 'descripcion' => 'Mantener piel siempre seca, aplicar cremas barreras', 'orden' => 4]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelMuyAlto->id, 'descripcion' => 'Vigilar humedad, incontinencia, uso de pañal; cambios inmediatos', 'orden' => 5]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelMuyAlto->id, 'descripcion' => 'Evaluar piel cada turno (mínimo cada 8 horas)', 'orden' => 6]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelMuyAlto->id, 'descripcion' => 'Control nutricional estricto: coordinar con nutrición, asegurar ingesta proteica', 'orden' => 7]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelMuyAlto->id, 'descripcion' => 'Minimizar fricción y cizalla: elevar cabecero <30° excepto indicación médica', 'orden' => 8]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelMuyAlto->id, 'descripcion' => 'Educar a familia sobre no arrastrar al paciente', 'orden' => 9]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelMuyAlto->id, 'descripcion' => 'Documentar todas las intervenciones y comunicar signos de alarma', 'orden' => 10]);

        // Acciones recomendadas - Riesgo Alto
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelAlto->id, 'descripcion' => 'Cambios posturales cada 3 horas', 'orden' => 1]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelAlto->id, 'descripcion' => 'Uso de superficies anti escaras si están disponibles', 'orden' => 2]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelAlto->id, 'descripcion' => 'Inspección de piel diaria', 'orden' => 3]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelAlto->id, 'descripcion' => 'Higiene e hidratación adecuada de la piel', 'orden' => 4]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelAlto->id, 'descripcion' => 'Evitar humedad prolongada; aplicar barreras protectoras', 'orden' => 5]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelAlto->id, 'descripcion' => 'Verificar que dispositivos médicos no generen presión', 'orden' => 6]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelAlto->id, 'descripcion' => 'Estimular la movilidad según tolerancia', 'orden' => 7]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelAlto->id, 'descripcion' => 'Documentar hallazgos y medidas realizadas', 'orden' => 8]);

        // Acciones recomendadas - Riesgo Moderado
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelModerado->id, 'descripcion' => 'Cambios posturales cada 4 horas', 'orden' => 1]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelModerado->id, 'descripcion' => 'Alternar posiciones y evitar apoyo constante en una zona', 'orden' => 2]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelModerado->id, 'descripcion' => 'Inspección de piel cada 24 horas', 'orden' => 3]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelModerado->id, 'descripcion' => 'Control de humedad: higiene después de incontinencia y uso de barreras', 'orden' => 4]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelModerado->id, 'descripcion' => 'Promover deambulación supervisada cuando sea posible', 'orden' => 5]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelModerado->id, 'descripcion' => 'Ajustar ropa de cama para evitar arrugas', 'orden' => 6]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelModerado->id, 'descripcion' => 'Educar al paciente/familia sobre cuidado de la piel', 'orden' => 7]);

        // Acciones recomendadas - Riesgo Bajo
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelBajo->id, 'descripcion' => 'Cambios posturales según tolerancia, idealmente cada 6 horas', 'orden' => 1]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelBajo->id, 'descripcion' => 'Mantener la piel limpia, seca, hidratada', 'orden' => 2]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelBajo->id, 'descripcion' => 'Revisar integridad de piel en cada turno de enfermería', 'orden' => 3]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelBajo->id, 'descripcion' => 'Fomentar movilidad, actividad física o ejercicios pasivos', 'orden' => 4]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelBajo->id, 'descripcion' => 'Evitar presión innecesaria por dispositivos', 'orden' => 5]);
        AccionRecomendada::create(['nivel_riesgo_id' => $nivelBajo->id, 'descripcion' => 'Reevaluar riesgo ante cualquier cambio clínico', 'orden' => 6]);

        // Acciones recomendadas - Sin Riesgo
        AccionRecomendada::create(['nivel_riesgo_id' => $sinRiesgo->id, 'descripcion' => 'Ofrecer cuidados básicos de piel: higiene, hidratación', 'orden' => 1]);
        AccionRecomendada::create(['nivel_riesgo_id' => $sinRiesgo->id, 'descripcion' => 'Fomentar movilidad independiente', 'orden' => 2]);
        AccionRecomendada::create(['nivel_riesgo_id' => $sinRiesgo->id, 'descripcion' => 'Evitar humedad prolongada', 'orden' => 3]);
        AccionRecomendada::create(['nivel_riesgo_id' => $sinRiesgo->id, 'descripcion' => 'Reevaluación cada 72 horas o ante cambios clínicos', 'orden' => 4]);
    }
}

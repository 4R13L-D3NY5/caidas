<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Internación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
            margin: 20px;
        }
        .header {
            border-bottom: 3px solid #2563eb;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #1f2937;
        }
        .header p {
            margin: 3px 0;
            color: #6b7280;
            font-size: 10px;
        }
        .section {
            background-color: #f9fafb;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            padding: 12px;
            margin-bottom: 12px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #1f2937;
            border-bottom: 2px solid #d1d5db;
            padding-bottom: 5px;
            margin-bottom: 8px;
        }
        .data-grid {
            display: table;
            width: 100%;
        }
        .data-row {
            display: table-row;
        }
        .data-cell {
            display: table-cell;
            padding: 4px 8px;
            width: 50%;
        }
        .label {
            font-size: 9px;
            color: #6b7280;
            font-weight: normal;
        }
        .value {
            font-size: 11px;
            font-weight: bold;
            color: #1f2937;
        }
        .risk-box {
            border: 2px solid #d1d5db;
            border-radius: 5px;
            padding: 10px;
            margin: 5px 0;
            display: inline-block;
            width: 48%;
            vertical-align: top;
        }
        .risk-box.alta {
            border-color: #10b981;
            background-color: #f0fdf4;
        }
        .risk-circle {
            display: inline-block;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            color: white;
            font-weight: bold;
            font-size: 16px;
            vertical-align: middle;
            margin-right: 10px;
        }
        .risk-info {
            display: inline-block;
            vertical-align: middle;
        }
        .risk-name {
            font-size: 13px;
            font-weight: bold;
            margin: 0;
        }
        .risk-score {
            font-size: 9px;
            color: #6b7280;
            margin: 0;
        }
        .actions-list {
            margin: 5px 0;
            padding-left: 15px;
            font-size: 9px;
        }
        .actions-list li {
            margin: 2px 0;
        }
        .seguimiento-box {
            border: 1px solid #d1d5db;
            border-radius: 5px;
            padding: 8px;
            margin: 8px 0;
            page-break-inside: avoid;
        }
        .seguimiento-box.caida {
            background-color: #fef2f2;
            border-color: #ef4444;
        }
        .seguimiento-box.sin-caida {
            background-color: #f0fdf4;
            border-color: #10b981;
        }
        .seguimiento-header {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 12px;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
            color: white;
        }
        .badge-red {
            background-color: #ef4444;
        }
        .badge-green {
            background-color: #10b981;
        }
        .detail-grid {
            margin-top: 5px;
        }
        .detail-item {
            margin: 3px 0;
            font-size: 10px;
        }
        .detail-label {
            font-weight: bold;
        }
        .progress-bar {
            background-color: #e5e7eb;
            border-radius: 10px;
            height: 8px;
            display: inline-block;
            width: 100px;
            vertical-align: middle;
            margin: 0 5px;
        }
        .progress-fill {
            background-color: #2563eb;
            height: 100%;
            border-radius: 10px;
        }
        .summary-box {
            background-color: #dbeafe;
            border: 2px solid #3b82f6;
            border-radius: 5px;
            padding: 10px;
            margin-top: 10px;
        }
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px solid #d1d5db;
            text-align: center;
            font-size: 9px;
            color: #6b7280;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <div class="header">
        <h1>HISTORIAL DE INTERNACIÓN</h1>
        <p>Sistema de Seguimiento de Riesgo de Pacientes</p>
        <p>Fecha de generación: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <!-- Datos del Paciente -->
    <div class="section">
        <div class="section-title">DATOS DEL PACIENTE</div>
        <div class="data-grid">
            <div class="data-row">
                <div class="data-cell">
                    <div class="label">Nombre Completo:</div>
                    <div class="value">{{ $admision->paciente->nombre }}</div>
                </div>
                <div class="data-cell">
                    <div class="label">Matrícula:</div>
                    <div class="value">{{ $admision->paciente->matricula }}</div>
                </div>
            </div>
            <div class="data-row">
                <div class="data-cell">
                    <div class="label">Edad:</div>
                    <div class="value">{{ $admision->paciente->edad }} años</div>
                </div>
                <div class="data-cell">
                    <div class="label">Tipo de Admisión:</div>
                    <div class="value">{{ $admision->tipo === 'caida' ? 'Riesgo de Caídas' : 'Riesgo de Úlceras por Presión' }}</div>
                </div>
            </div>
            <div class="data-row">
                <div class="data-cell">
                    <div class="label">Fecha de Ingreso:</div>
                    <div class="value">{{ $admision->fecha_valoracion->format('d/m/Y') }}</div>
                </div>
                <div class="data-cell">
                    <div class="label">Turno de Ingreso:</div>
                    <div class="value">{{ $admision->turno }}</div>
                </div>
            </div>
            @if($admision->estado === 'alta')
            <div class="data-row">
                <div class="data-cell">
                    <div class="label">Fecha de Alta:</div>
                    <div class="value">{{ $admision->fecha_alta->format('d/m/Y') }}</div>
                </div>
                <div class="data-cell">
                    <div class="label">Estado:</div>
                    <div class="value" style="color: #10b981;">ALTA</div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Diagnósticos -->
    <div class="section">
        <div class="section-title">DIAGNÓSTICOS</div>
        <div class="detail-item">
            <span class="detail-label">Diagnóstico de Ingreso:</span> {{ $admision->diagnostico_inicial }}
        </div>
        @if($admision->diagnostico_final)
        <div class="detail-item">
            <span class="detail-label">Diagnóstico de Salida:</span> {{ $admision->diagnostico_final }}
        </div>
        @endif
    </div>

    <!-- Niveles de Riesgo -->
    @if($valoracionInicial)
    <div class="section">
        <div class="section-title">NIVELES DE RIESGO</div>
        
        <!-- Nivel de Ingreso -->
        <div class="risk-box">
            <div class="label" style="margin-bottom: 5px;">VALORACIÓN DE INGRESO</div>
            <div>
                <div class="risk-circle" style="background-color: {{ $valoracionInicial->nivelRiesgo->codigo_color }}">
                    {{ $valoracionInicial->puntaje_total }}
                </div>
                <div class="risk-info">
                    <p class="risk-name" style="color: {{ $valoracionInicial->nivelRiesgo->codigo_color }}">
                        {{ $valoracionInicial->nivelRiesgo->nombre }}
                    </p>
                    <p class="risk-score">Puntaje: {{ $valoracionInicial->puntaje_total }} puntos</p>
                </div>
            </div>
            <div style="margin-top: 8px; padding-top: 8px; border-top: 1px solid #d1d5db;">
                <div class="label">Acciones Recomendadas:</div>
                <ul class="actions-list">
                    @foreach($accionesRecomendadas as $accion)
                    <li>{{ $accion->descripcion }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Nivel de Alta -->
        @if($valoracionAlta)
        <div class="risk-box alta">
            <div class="label" style="margin-bottom: 5px;">VALORACIÓN DE ALTA</div>
            <div>
                <div class="risk-circle" style="background-color: {{ $valoracionAlta->nivelRiesgo->codigo_color }}">
                    {{ $valoracionAlta->puntaje_total }}
                </div>
                <div class="risk-info">
                    <p class="risk-name" style="color: {{ $valoracionAlta->nivelRiesgo->codigo_color }}">
                        {{ $valoracionAlta->nivelRiesgo->nombre }}
                    </p>
                    <p class="risk-score">Puntaje: {{ $valoracionAlta->puntaje_total }} puntos</p>
                </div>
            </div>
            <div style="margin-top: 8px; padding-top: 8px; border-top: 1px solid #10b981;">
                @if($valoracionAlta->puntaje_total < $valoracionInicial->puntaje_total)
                <div style="color: #10b981; font-weight: bold; font-size: 10px;">
                    ✓ Mejoría: Reducción de {{ $valoracionInicial->puntaje_total - $valoracionAlta->puntaje_total }} puntos
                </div>
                @elseif($valoracionAlta->puntaje_total > $valoracionInicial->puntaje_total)
                <div style="color: #ef4444; font-weight: bold; font-size: 10px;">
                    ⚠ Incremento de {{ $valoracionAlta->puntaje_total - $valoracionInicial->puntaje_total }} puntos
                </div>
                @else
                <div style="color: #6b7280; font-weight: bold; font-size: 10px;">
                    = Sin cambios
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
    @endif

    <div class="page-break"></div>

    <!-- Seguimientos Diarios -->
    <div class="section">
        <div class="section-title">SEGUIMIENTOS DIARIOS</div>
        
        @php
            $totalEventos = $admision->tipo === 'caida'
                ? $seguimientos->where('hubo_caida', true)->count()
                : $seguimientos->where('hubo_ulcera', true)->count();
            
            $tituloEvento = $admision->tipo === 'caida' ? 'Caídas' : 'Úlceras';
            $textoRegistrado = $admision->tipo === 'caida' ? 'CAÍDA REGISTRADA' : 'ÚLCERA REGISTRADA';
            $textoSinEvento = $admision->tipo === 'caida' ? 'SIN CAÍDAS' : 'SIN ÚLCERAS';
        @endphp
        
        <div style="background-color: #dbeafe; padding: 8px; border-radius: 5px; margin-bottom: 10px;">
            <strong>Total de {{ $tituloEvento }} Registradas:</strong> 
            <span style="font-size: 14px; color: {{ $totalEventos > 0 ? '#ef4444' : '#10b981' }}; font-weight: bold;">
                {{ $totalEventos }}
            </span>
        </div>

        @foreach($seguimientos as $seguimiento)
        @php
            $huboEvento = $admision->tipo === 'caida' ? $seguimiento->hubo_caida : $seguimiento->hubo_ulcera;
        @endphp
        <div class="seguimiento-box {{ $huboEvento ? 'caida' : 'sin-caida' }}">
            <div class="seguimiento-header">
                {{ $seguimiento->fecha->format('d/m/Y') }} - {{ $seguimiento->turno }}
                <span class="badge {{ $huboEvento ? 'badge-red' : 'badge-green' }}" style="float: right;">
                    {{ $huboEvento ? $textoRegistrado : $textoSinEvento }}
                </span>
            </div>

            @if($huboEvento)
                <div class="detail-grid">
                    @if($admision->tipo === 'caida')
                        <div class="detail-item"><span class="detail-label">Hora:</span> {{ $seguimiento->hora_caida }}</div>
                        <div class="detail-item"><span class="detail-label">Lugar:</span> {{ $seguimiento->lugar }}</div>
                        <div class="detail-item"><span class="detail-label">Tipo de Caída:</span> {{ $seguimiento->tipo_caida }}</div>
                        <div class="detail-item"><span class="detail-label">Hubo Lesión:</span> {{ $seguimiento->hubo_lesion ? 'Sí' : 'No' }}</div>
                        @if($seguimiento->hubo_lesion && $seguimiento->descripcion_lesion)
                            <div class="detail-item"><span class="detail-label">Descripción de Lesión:</span> {{ $seguimiento->descripcion_lesion }}</div>
                        @endif
                        @if($seguimiento->acciones_tomadas && count($seguimiento->acciones_tomadas) > 0)
                            <div class="detail-item">
                                <span class="detail-label">Acciones Tomadas:</span>
                                <ul style="margin: 2px 0; padding-left: 15px;">
                                    @foreach($seguimiento->acciones_tomadas as $accion)
                                    <li>{{ $accion }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if($seguimiento->observacion)
                            <div class="detail-item"><span class="detail-label">Observación:</span> {{ $seguimiento->observacion }}</div>
                        @endif
                    @else
                        <!-- Detalles de Úlcera -->
                        <div class="detail-item"><span class="detail-label">Estadio:</span> {{ $seguimiento->estado_ulcera }}</div>
                        <div class="detail-item"><span class="detail-label">Ubicación:</span> {{ $seguimiento->ubicacion_ulcera }}</div>
                        <div class="detail-item"><span class="detail-label">Descripción Clínica:</span> {{ $seguimiento->descripcion_ulcera }}</div>
                        @if($seguimiento->observaciones_ulcera)
                            <div class="detail-item"><span class="detail-label">Observaciones:</span> {{ $seguimiento->observaciones_ulcera }}</div>
                        @endif
                    @endif
                </div>
            @endif

            @php
                $cotejo = $seguimiento->listasCotejo->first();
            @endphp
            @if($cotejo)
            <div style="margin-top: 8px; padding-top: 8px; border-top: 1px solid #d1d5db;">
                <span style="font-size: 10px; font-weight: bold;">Cumplimiento de Acciones:</span>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ $cotejo->porcentaje_cumplimiento }}%"></div>
                </div>
                <span style="font-weight: bold; color: #2563eb;">{{ $cotejo->porcentaje_cumplimiento }}%</span>
                <div style="font-size: 8px; color: #6b7280; margin-top: 2px;">
                    Verificado por: {{ $cotejo->supervisor->name }} - {{ $cotejo->fecha_verificacion->format('d/m/Y') }}
                </div>
            </div>
            @endif
        </div>
        @endforeach

        <!-- Resumen de Cumplimiento -->
        @php
            $cotejosConPorcentaje = $seguimientos->map(function($seg) {
                return $seg->listasCotejo->first();
            })->filter();
            
            $promedioCumplimiento = $cotejosConPorcentaje->count() > 0 
                ? round($cotejosConPorcentaje->avg('porcentaje_cumplimiento'), 1)
                : 0;
        @endphp

        @if($cotejosConPorcentaje->count() > 0)
        <div class="summary-box">
            <strong style="font-size: 12px;">Resumen de Cumplimiento</strong><br>
            <span style="font-size: 10px;">Promedio General:</span>
            <div class="progress-bar" style="width: 150px;">
                <div class="progress-fill" style="width: {{ $promedioCumplimiento }}%"></div>
            </div>
            <span style="font-weight: bold; color: #2563eb; font-size: 14px;">{{ $promedioCumplimiento }}%</span>
            <span style="font-size: 9px; color: #6b7280;">({{ $cotejosConPorcentaje->count() }} verificaciones)</span>
        </div>
        @endif
    </div>

    <!-- Pie de Página -->
    <div class="footer">
        <p>Este documento fue generado automáticamente por el Sistema de Seguimiento de Riesgo de Pacientes</p>
        <p>{{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>

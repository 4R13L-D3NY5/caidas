<div class="max-w-7xl mx-auto p-8">
    <!-- Botón de Impresión -->
    <div class="no-print mb-6 flex justify-between items-center">
        <a href="{{ route('paciente.dashboard', ['admision' => $admision->id]) }}" 
            class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
            ← Volver al Dashboard
        </a>
        <div class="flex gap-2">
            <a href="{{ route('paciente.exportar-pdf', ['admision' => $admision->id]) }}" 
                class="px-6 py-3 bg-red-600 text-white rounded-md hover:bg-red-700 font-semibold">
                📄 Descargar PDF
            </a>
            <button onclick="window.print()" 
                class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-semibold">
                🖨️ Imprimir
            </button>
        </div>
    </div>

    <!-- Encabezado del Documento -->
    <div class="border-b-4 border-blue-600 pb-4 mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">HISTORIAL DE INTERNACIÓN</h1>
        <p class="text-lg text-gray-600">Sistema de Seguimiento de Riesgo de Pacientes</p>
        <p class="text-sm text-gray-500">Fecha de generación: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <!-- Datos del Paciente -->
    <div class="bg-gray-50 border border-gray-300 rounded-lg p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 border-gray-300 pb-2">DATOS DEL PACIENTE</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-600">Nombre Completo:</p>
                <p class="text-lg font-semibold">{{ $admision->paciente->nombre }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Matrícula:</p>
                <p class="text-lg font-semibold">{{ $admision->paciente->matricula }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Edad:</p>
                <p class="text-lg font-semibold">{{ $admision->paciente->edad }} años</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Tipo de Admisión:</p>
                <p class="text-lg font-semibold">{{ $admision->tipo === 'caida' ? 'Riesgo de Caídas' : 'Riesgo de Úlceras por Presión' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Fecha de Ingreso:</p>
                <p class="text-lg font-semibold">{{ $admision->fecha_valoracion->format('d/m/Y') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Turno de Ingreso:</p>
                <p class="text-lg font-semibold">{{ $admision->turno }}</p>
            </div>
            @if($admision->estado === 'alta')
                <div>
                    <p class="text-sm text-gray-600">Fecha de Alta:</p>
                    <p class="text-lg font-semibold">{{ $admision->fecha_alta->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Estado:</p>
                    <p class="text-lg font-semibold text-green-700">ALTA</p>
                </div>
            @else
                <div>
                    <p class="text-sm text-gray-600">Estado:</p>
                    <p class="text-lg font-semibold text-blue-700">ACTIVO</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Diagnósticos -->
    <div class="bg-white border border-gray-300 rounded-lg p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 border-gray-300 pb-2">DIAGNÓSTICOS</h2>
        <div class="grid grid-cols-1 gap-4">
            <div>
                <p class="text-sm text-gray-600 font-semibold">Diagnóstico de Ingreso:</p>
                <p class="text-base">{{ $admision->diagnostico_inicial }}</p>
            </div>
            @if($admision->diagnostico_final)
                <div>
                    <p class="text-sm text-gray-600 font-semibold">Diagnóstico de Salida:</p>
                    <p class="text-base">{{ $admision->diagnostico_final }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Comparación de Niveles de Riesgo -->
    @if($valoracionInicial)
        <div class="bg-white border border-gray-300 rounded-lg p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 border-gray-300 pb-2">NIVELES DE RIESGO</h2>
            
            <div class="grid grid-cols-{{ $valoracionAlta ? '2' : '1' }} gap-6">
                <!-- Nivel de Ingreso -->
                <div class="border-2 border-gray-300 rounded-lg p-4">
                    <h3 class="text-sm font-bold text-gray-600 mb-3 uppercase">Valoración de Ingreso</h3>
                    <div class="flex items-center gap-4 mb-3">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center text-white font-bold text-2xl"
                            style="background-color: {{ $valoracionInicial->nivelRiesgo->codigo_color }}">
                            {{ $valoracionInicial->puntaje_total }}
                        </div>
                        <div>
                            <h4 class="text-xl font-bold" style="color: {{ $valoracionInicial->nivelRiesgo->codigo_color }}">
                                {{ $valoracionInicial->nivelRiesgo->nombre }}
                            </h4>
                            <p class="text-sm text-gray-600">Puntaje: {{ $valoracionInicial->puntaje_total }} puntos</p>
                        </div>
                    </div>
                    
                    <!-- Acciones Recomendadas -->
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <p class="text-sm font-semibold text-gray-700 mb-2">Acciones Recomendadas:</p>
                        <ul class="text-xs space-y-1">
                            @foreach($accionesRecomendadas as $accion)
                                <li class="flex items-start gap-1">
                                    <span class="text-blue-600">•</span>
                                    <span>{{ $accion->descripcion }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Nivel de Alta -->
                @if($valoracionAlta)
                    <div class="border-2 border-green-500 rounded-lg p-4 bg-green-50">
                        <h3 class="text-sm font-bold text-gray-600 mb-3 uppercase">Valoración de Alta</h3>
                        <div class="flex items-center gap-4 mb-3">
                            <div class="w-16 h-16 rounded-full flex items-center justify-center text-white font-bold text-2xl"
                                style="background-color: {{ $valoracionAlta->nivelRiesgo->codigo_color }}">
                                {{ $valoracionAlta->puntaje_total }}
                            </div>
                            <div>
                                <h4 class="text-xl font-bold" style="color: {{ $valoracionAlta->nivelRiesgo->codigo_color }}">
                                    {{ $valoracionAlta->nivelRiesgo->nombre }}
                                </h4>
                                <p class="text-sm text-gray-600">Puntaje: {{ $valoracionAlta->puntaje_total }} puntos</p>
                            </div>
                        </div>

                        <!-- Comparación -->
                        <div class="mt-4 pt-4 border-t border-green-300">
                            @if($valoracionAlta->puntaje_total < $valoracionInicial->puntaje_total)
                                <p class="text-sm font-semibold text-green-700">
                                    ✓ Mejoría: Reducción de {{ $valoracionInicial->puntaje_total - $valoracionAlta->puntaje_total }} puntos
                                </p>
                            @elseif($valoracionAlta->puntaje_total > $valoracionInicial->puntaje_total)
                                <p class="text-sm font-semibold text-red-700">
                                    ⚠ Incremento de {{ $valoracionAlta->puntaje_total - $valoracionInicial->puntaje_total }} puntos
                                </p>
                            @else
                                <p class="text-sm font-semibold text-gray-700">
                                    = Sin cambios en el nivel de riesgo
                                </p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Seguimientos Diarios -->
    <div class="bg-white border border-gray-300 rounded-lg p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 border-gray-300 pb-2">SEGUIMIENTOS DIARIOS</h2>
        
        @if($seguimientos->count() > 0)
            @php
                $totalEventos = $admision->tipo === 'caida'
                    ? $seguimientos->where('hubo_caida', true)->count()
                    : $seguimientos->where('hubo_ulcera', true)->count();
                
                $tituloEvento = $admision->tipo === 'caida' ? 'Caídas' : 'Úlceras';
                $textoRegistrado = $admision->tipo === 'caida' ? 'CAÍDA REGISTRADA' : 'ÚLCERA REGISTRADA';
                $textoSinEvento = $admision->tipo === 'caida' ? 'SIN CAÍDAS' : 'SIN ÚLCERAS';
            @endphp
            
            <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded">
                <p class="font-semibold">Total de {{ $tituloEvento }} Registradas: 
                    <span class="text-lg {{ $totalEventos > 0 ? 'text-red-600' : 'text-green-600' }}">{{ $totalEventos }}</span>
                </p>
            </div>

            <div class="space-y-4">
                @foreach($seguimientos as $seguimiento)
                    @php
                        $huboEvento = $admision->tipo === 'caida' ? $seguimiento->hubo_caida : $seguimiento->hubo_ulcera;
                    @endphp
                    <div class="border border-gray-300 rounded-lg p-4 {{ $huboEvento ? 'bg-red-50 border-red-300' : 'bg-green-50 border-green-300' }}">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-bold text-lg">{{ $seguimiento->fecha->format('d/m/Y') }} - {{ $seguimiento->turno }}</h3>
                            </div>
                            <div>
                                <span class="px-3 py-1 {{ $huboEvento ? 'bg-red-600' : 'bg-green-600' }} text-white rounded-full text-sm font-bold">
                                    {{ $huboEvento ? $textoRegistrado : $textoSinEvento }}
                                </span>
                            </div>
                        </div>

                        @if($huboEvento)
                            <div class="grid grid-cols-2 gap-3 text-sm">
                                @if($admision->tipo === 'caida')
                                    <div>
                                        <span class="font-semibold">Hora:</span> {{ $seguimiento->hora_caida }}
                                    </div>
                                    <div>
                                        <span class="font-semibold">Lugar:</span> {{ $seguimiento->lugar }}
                                    </div>
                                    <div>
                                        <span class="font-semibold">Tipo de Caída:</span> {{ $seguimiento->tipo_caida }}
                                    </div>
                                    <div>
                                        <span class="font-semibold">Hubo Lesión:</span> {{ $seguimiento->hubo_lesion ? 'Sí' : 'No' }}
                                    </div>
                                    @if($seguimiento->hubo_lesion && $seguimiento->descripcion_lesion)
                                        <div class="col-span-2">
                                            <span class="font-semibold">Descripción de Lesión:</span> {{ $seguimiento->descripcion_lesion }}
                                        </div>
                                    @endif
                                    @if($seguimiento->acciones_tomadas && count($seguimiento->acciones_tomadas) > 0)
                                        <div class="col-span-2">
                                            <span class="font-semibold">Acciones Tomadas:</span>
                                            <ul class="list-disc list-inside ml-4 mt-1">
                                                @foreach($seguimiento->acciones_tomadas as $accion)
                                                    <li>{{ $accion }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @if($seguimiento->observacion)
                                        <div class="col-span-2">
                                            <span class="font-semibold">Observación:</span> {{ $seguimiento->observacion }}
                                        </div>
                                    @endif
                                @else
                                    <!-- Detalles de Úlcera -->
                                    <div class="col-span-2">
                                        <span class="font-semibold">Estadio:</span> {{ $seguimiento->estado_ulcera }}
                                    </div>
                                    <div class="col-span-2">
                                        <span class="font-semibold">Ubicación:</span> {{ $seguimiento->ubicacion_ulcera }}
                                    </div>
                                    <div class="col-span-2">
                                        <span class="font-semibold">Descripción Clínica:</span> {{ $seguimiento->descripcion_ulcera }}
                                    </div>
                                    @if($seguimiento->observaciones_ulcera)
                                        <div class="col-span-2">
                                            <span class="font-semibold">Observaciones:</span> {{ $seguimiento->observaciones_ulcera }}
                                        </div>
                                    @endif
                                @endif
                            </div>
                        @else
                            <p class="text-sm text-gray-600">No se registraron {{ strtolower($tituloEvento) }} durante este turno.</p>
                        @endif

                        <!-- Verificación de Cumplimiento -->
                        @php
                            $cotejo = $seguimiento->listasCotejo->first();
                        @endphp
                        @if($cotejo)
                            <div class="mt-3 pt-3 border-t border-gray-300">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-semibold">Cumplimiento de Acciones:</span>
                                    <div class="flex items-center gap-2">
                                        <div class="w-32 bg-gray-300 rounded-full h-2">
                                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $cotejo->porcentaje_cumplimiento }}%"></div>
                                        </div>
                                        <span class="font-bold text-blue-700">{{ $cotejo->porcentaje_cumplimiento }}%</span>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-600 mt-1">
                                    Verificado por: {{ $cotejo->supervisor->name }} - {{ $cotejo->fecha_verificacion->format('d/m/Y') }}
                                </p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

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
                <div class="mt-6 p-4 bg-blue-100 border-2 border-blue-400 rounded-lg">
                    <h3 class="font-bold text-lg mb-2">Resumen de Cumplimiento</h3>
                    <div class="flex items-center gap-3">
                        <span class="text-sm">Promedio General:</span>
                        <div class="w-48 bg-gray-300 rounded-full h-3">
                            <div class="bg-blue-600 h-3 rounded-full" style="width: {{ $promedioCumplimiento }}%"></div>
                        </div>
                        <span class="font-bold text-blue-700 text-xl">{{ $promedioCumplimiento }}%</span>
                        <span class="text-sm text-gray-600">({{ $cotejosConPorcentaje->count() }} verificaciones)</span>
                    </div>
                </div>
            @endif
        @else
            <p class="text-gray-500">No hay seguimientos registrados.</p>
        @endif
    </div>

    <!-- Pie de Página -->
    <div class="mt-8 pt-4 border-t-2 border-gray-300 text-center text-sm text-gray-600">
        <p>Este documento fue generado automáticamente por el Sistema de Seguimiento de Riesgo de Pacientes</p>
        <p class="mt-1">{{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</div>

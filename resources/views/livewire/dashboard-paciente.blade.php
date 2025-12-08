<div class="max-w-7xl mx-auto py-8 px-4">
    <!-- Encabezado del Paciente -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $admision->paciente->nombre }}</h1>
                <p class="text-gray-600 mt-1">Matrícula: {{ $admision->paciente->matricula }} | Edad: {{ $admision->paciente->edad }} años</p>
                <p class="text-gray-600">
                    Tipo: <span class="font-semibold">{{ $admision->tipo === 'caida' ? 'Caídas' : 'Úlceras por Presión' }}</span>
                </p>
                <p class="text-gray-600">
                    Estado: 
                    <span class="px-2 py-1 rounded text-sm font-semibold {{ $admision->estado === 'activo' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($admision->estado) }}
                    </span>
                </p>
            </div>
            @if($admision->estado === 'activo')
                <div class="flex gap-2">
                    <a href="{{ route('seguimiento.crear', ['admision' => $admision->id]) }}" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        + Nuevo Seguimiento
                    </a>
                    <a href="{{ route('valoracion.alta', ['admision' => $admision->id]) }}" 
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Dar de Alta
                    </a>
                    <a href="{{ route('paciente.historial', ['admision' => $admision->id]) }}" 
                        target="_blank"
                        class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                        🖨️ Imprimir Historial
                    </a>
                </div>
            @else
                <div class="flex gap-2">
                    <div class="px-4 py-2 bg-gray-100 text-gray-600 rounded-md border border-gray-300">
                        <span class="font-semibold">Paciente dado de alta</span>
                        <p class="text-xs mt-1">{{ $admision->fecha_alta->format('d/m/Y') }}</p>
                    </div>
                    <a href="{{ route('paciente.historial', ['admision' => $admision->id]) }}" 
                        target="_blank"
                        class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                        🖨️ Imprimir Historial
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Nivel de Riesgo -->
    @if($valoracionInicial)
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            @if($admision->estado === 'alta')
                <!-- Comparación de Riesgos (Ingreso vs Alta) -->
                <h2 class="text-xl font-bold text-gray-800 mb-4">Comparación de Niveles de Riesgo</h2>
                
                @php
                    $valoracionAlta = $admision->valoraciones->where('tipo_valoracion', 'alta')->first();
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Riesgo de Ingreso -->
                    <div class="border-2 border-gray-200 rounded-lg p-4">
                        <h3 class="text-sm font-semibold text-gray-500 mb-3 uppercase">Nivel de Ingreso</h3>
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-full flex items-center justify-center text-white font-bold text-2xl"
                                style="background-color: {{ $nivelRiesgo->codigo_color }}">
                                {{ $valoracionInicial->puntaje_total }}
                            </div>
                            <div>
                                <h4 class="text-xl font-bold" style="color: {{ $nivelRiesgo->codigo_color }}">
                                    {{ $nivelRiesgo->nombre }}
                                </h4>
                                <p class="text-gray-600 text-sm">Puntaje: {{ $valoracionInicial->puntaje_total }} puntos</p>
                                <p class="text-gray-500 text-xs mt-1">{{ $admision->fecha_valoracion->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Riesgo de Alta -->
                    @if($valoracionAlta)
                        <div class="border-2 border-green-500 rounded-lg p-4 bg-green-50">
                            <h3 class="text-sm font-semibold text-gray-500 mb-3 uppercase">Nivel de Alta</h3>
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 rounded-full flex items-center justify-center text-white font-bold text-2xl"
                                    style="background-color: {{ $valoracionAlta->nivelRiesgo->codigo_color }}">
                                    {{ $valoracionAlta->puntaje_total }}
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold" style="color: {{ $valoracionAlta->nivelRiesgo->codigo_color }}">
                                        {{ $valoracionAlta->nivelRiesgo->nombre }}
                                    </h4>
                                    <p class="text-gray-600 text-sm">Puntaje: {{ $valoracionAlta->puntaje_total }} puntos</p>
                                    <p class="text-gray-500 text-xs mt-1">{{ $admision->fecha_alta->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Indicador de Mejora/Empeoramiento -->
                @if($valoracionAlta)
                    <div class="mt-4 p-3 rounded-lg {{ $valoracionAlta->puntaje_total < $valoracionInicial->puntaje_total ? 'bg-green-100 border border-green-300' : ($valoracionAlta->puntaje_total > $valoracionInicial->puntaje_total ? 'bg-red-100 border border-red-300' : 'bg-gray-100 border border-gray-300') }}">
                        @if($valoracionAlta->puntaje_total < $valoracionInicial->puntaje_total)
                            <p class="text-green-800 font-semibold">
                                ✓ Mejoría: Reducción de {{ $valoracionInicial->puntaje_total - $valoracionAlta->puntaje_total }} puntos en el nivel de riesgo
                            </p>
                        @elseif($valoracionAlta->puntaje_total > $valoracionInicial->puntaje_total)
                            <p class="text-red-800 font-semibold">
                                ⚠ Incremento de {{ $valoracionAlta->puntaje_total - $valoracionInicial->puntaje_total }} puntos en el nivel de riesgo
                            </p>
                        @else
                            <p class="text-gray-800 font-semibold">
                                = Nivel de riesgo sin cambios
                            </p>
                        @endif
                    </div>
                @endif
            @else
                <!-- Nivel de Riesgo Actual (Paciente Activo) -->
                <h2 class="text-xl font-bold text-gray-800 mb-4">Nivel de Riesgo Actual</h2>
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center text-white font-bold text-2xl"
                        style="background-color: {{ $nivelRiesgo->codigo_color }}">
                        {{ $valoracionInicial->puntaje_total }}
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold" style="color: {{ $nivelRiesgo->codigo_color }}">
                            {{ $nivelRiesgo->nombre }}
                        </h3>
                        <p class="text-gray-600">Puntaje: {{ $valoracionInicial->puntaje_total }} puntos</p>
                    </div>
                </div>
            @endif

            <!-- Acciones Recomendadas -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Acciones Recomendadas {{ $admision->estado === 'alta' ? '(Al Ingreso)' : '' }}</h3>
                <ul class="space-y-2">
                    @foreach($accionesRecomendadas as $accion)
                        <li class="flex items-start gap-2">
                            <span class="text-blue-600 mt-1">✓</span>
                            <span class="text-gray-700">{{ $accion->descripcion }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Seguimientos Diarios -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Seguimientos Diarios</h2>
        
        @if($seguimientos->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Turno</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                {{ $admision->tipo === 'caida' ? 'Caída' : 'Úlcera' }}
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Detalles</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">% Cumplimiento</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($seguimientos as $seguimiento)
                            @php
                                $cotejo = $seguimiento->listasCotejo->first();
                            @endphp
                            <tr>
                                <td class="px-4 py-3 text-sm">{{ $seguimiento->fecha->format('d/m/Y') }}</td>
                                <td class="px-4 py-3 text-sm">{{ $seguimiento->turno }}</td>
                                <td class="px-4 py-3 text-sm">
                                    @php
                                        $huboEvento = $admision->tipo === 'caida' ? $seguimiento->hubo_caida : $seguimiento->hubo_ulcera;
                                    @endphp
                                    @if($huboEvento)
                                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-semibold">Sí</span>
                                    @else
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-semibold">No</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if($huboEvento)
                                        <div class="text-xs text-gray-600">
                                            @if($admision->tipo === 'caida')
                                                <p>Lugar: {{ $seguimiento->lugar }}</p>
                                                <p>Tipo: {{ $seguimiento->tipo_caida }}</p>
                                            @else
                                                <p>Estado: {{ $seguimiento->estado_ulcera }}</p>
                                                <p>Ubicación: {{ $seguimiento->ubicacion_ulcera }}</p>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if($cotejo)
                                        <div class="space-y-1">
                                            <div class="flex items-center gap-2">
                                                <div class="w-20 bg-gray-200 rounded-full h-2">
                                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $cotejo->porcentaje_cumplimiento }}%"></div>
                                                </div>
                                                <span class="font-semibold text-blue-600">{{ $cotejo->porcentaje_cumplimiento }}%</span>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-gray-400">Pendiente</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <div class="flex flex-col gap-1">
                                        @if(auth()->user()->rol === 'supervisora')
                                            @if($cotejo)
                                                <span class="text-green-600 text-xs">✓ Verificado</span>
                                                @if($cotejo->porcentaje_cumplimiento < 100)
                                                    @if($cotejo->llamada_atencion)
                                                        <button wire:click="quitarLlamadaAtencion({{ $cotejo->id }})" 
                                                            class="px-2 py-1 bg-yellow-100 text-yellow-800 border border-yellow-300 rounded text-xs hover:bg-yellow-200 flex items-center gap-1">
                                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                            </svg>
                                                            Recomendación
                                                        </button>
                                                    @else
                                                        <button wire:click="marcarLlamadaAtencion({{ $cotejo->id }})" 
                                                            class="px-2 py-1 bg-gray-100 text-gray-600 border border-gray-300 rounded text-xs hover:bg-yellow-50 hover:border-yellow-300">
                                                            Recomendación
                                                        </button>
                                                    @endif
                                                @endif
                                            @else
                                                <a href="{{ route('cotejo.crear', ['seguimiento' => $seguimiento->id]) }}" 
                                                    class="text-blue-600 hover:underline">
                                                    Verificar Acciones
                                                </a>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-blue-50 border-t-2 border-blue-200">
                        <tr>
                            <td colspan="2" class="px-4 py-3 text-sm font-bold text-gray-800 text-right">
                                Total de {{ $admision->tipo === 'caida' ? 'Caídas' : 'Úlceras' }}:
                            </td>
                            <td class="px-4 py-3 text-sm">
                                @php
                                    $totalEventos = $admision->tipo === 'caida' 
                                        ? $seguimientos->where('hubo_caida', true)->count()
                                        : $seguimientos->where('hubo_ulcera', true)->count();
                                @endphp
                                <span class="px-3 py-1 {{ $totalEventos > 0 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }} rounded-full font-bold text-lg">
                                    {{ $totalEventos }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm font-bold text-gray-800 text-right">
                                Promedio de Cumplimiento:
                            </td>
                            <td class="px-4 py-3 text-sm">
                                @php
                                    $cotejosConPorcentaje = $seguimientos->map(function($seg) {
                                        return $seg->listasCotejo->first();
                                    })->filter();
                                    
                                    $promedio = $cotejosConPorcentaje->count() > 0 
                                        ? round($cotejosConPorcentaje->avg('porcentaje_cumplimiento'), 1)
                                        : 0;
                                @endphp
                                <div class="flex items-center gap-2">
                                    <div class="w-24 bg-gray-300 rounded-full h-3">
                                        <div class="bg-blue-600 h-3 rounded-full" style="width: {{ $promedio }}%"></div>
                                    </div>
                                    <span class="font-bold text-blue-700 text-lg">{{ $promedio }}%</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                <span class="text-xs">{{ $cotejosConPorcentaje->count() }} verificaciones</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <p class="text-gray-500">No hay seguimientos registrados aún.</p>
        @endif
    </div>
</div>

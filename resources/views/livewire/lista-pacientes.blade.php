<div>
    <!-- Tabs -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6">
                <button wire:click="$set('tabActiva', 'activos')" 
                    class="border-b-2 py-4 px-1 text-sm font-medium {{ $tabActiva === 'activos' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Pacientes Activos ({{ $pacientesActivos->count() }})
                </button>
                <button wire:click="$set('tabActiva', 'alta')" 
                    class="border-b-2 py-4 px-1 text-sm font-medium {{ $tabActiva === 'alta' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Pacientes de Alta ({{ $pacientesAlta->count() }})
                </button>
            </nav>
        </div>

        <div class="p-6">
            <!-- Contenido Tab Activos -->
            @if($tabActiva === 'activos')
                @if($pacientesActivos->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paciente</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Matrícula</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nivel de Riesgo</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Ingreso</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pacientesActivos as $admision)
                                    @php
                                        $valoracion = $admision->valoraciones->where('tipo_valoracion', 'inicial')->first();
                                    @endphp
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                            {{ $admision->paciente->nombre }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-500">
                                            {{ $admision->paciente->matricula }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-500">
                                            {{ $admision->tipo === 'caida' ? 'Caídas' : 'Úlceras' }}
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            @if($valoracion)
                                                <span class="px-2 py-1 rounded text-xs font-semibold" 
                                                    style="background-color: {{ $valoracion->nivelRiesgo->codigo_color }}20; color: {{ $valoracion->nivelRiesgo->codigo_color }}">
                                                    {{ $valoracion->nivelRiesgo->nombre }}
                                                </span>
                                            @else
                                                <span class="text-gray-400">Pendiente</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-500">
                                            {{ $admision->fecha_valoracion->format('d/m/Y') }}
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <a href="{{ route('paciente.dashboard', ['admision' => $admision->id]) }}" 
                                                class="text-blue-600 hover:underline">
                                                Ver Detalles
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500">No hay pacientes activos en este momento.</p>
                @endif
            @endif

            <!-- Contenido Tab Alta -->
            @if($tabActiva === 'alta')
                @if($pacientesAlta->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paciente</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Matrícula</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nivel Ingreso</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nivel Alta</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Alta</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pacientesAlta as $admision)
                                    @php
                                        $valoracionInicial = $admision->valoraciones->where('tipo_valoracion', 'inicial')->first();
                                        $valoracionAlta = $admision->valoraciones->where('tipo_valoracion', 'alta')->first();
                                    @endphp
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                            {{ $admision->paciente->nombre }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-500">
                                            {{ $admision->paciente->matricula }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-500">
                                            {{ $admision->tipo === 'caida' ? 'Caídas' : 'Úlceras' }}
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            @if($valoracionInicial)
                                                <span class="px-2 py-1 rounded text-xs font-semibold" 
                                                    style="background-color: {{ $valoracionInicial->nivelRiesgo->codigo_color }}20; color: {{ $valoracionInicial->nivelRiesgo->codigo_color }}">
                                                    {{ $valoracionInicial->nivelRiesgo->nombre }}
                                                </span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            @if($valoracionAlta)
                                                <span class="px-2 py-1 rounded text-xs font-semibold" 
                                                    style="background-color: {{ $valoracionAlta->nivelRiesgo->codigo_color }}20; color: {{ $valoracionAlta->nivelRiesgo->codigo_color }}">
                                                    {{ $valoracionAlta->nivelRiesgo->nombre }}
                                                </span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-500">
                                            {{ $admision->fecha_alta ? $admision->fecha_alta->format('d/m/Y') : '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <a href="{{ route('paciente.dashboard', ['admision' => $admision->id]) }}" 
                                                class="text-blue-600 hover:underline">
                                                Ver Historial
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500">No hay pacientes dados de alta.</p>
                @endif
            @endif
        </div>
    </div>
</div>

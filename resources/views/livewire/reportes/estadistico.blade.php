<div>
    @php
        $periodo = $datos['periodo'] ?? ['inicio' => now()->subMonth()->format('Y-m-d'), 'fin' => now()->format('Y-m-d')];
        $admisiones = $datos['admisiones'] ?? ['total' => 0, 'activas' => 0, 'altas' => 0, 'por_tipo' => []];
        $caidas = $datos['caidas'] ?? ['total' => 0, 'con_lesion' => 0, 'por_turno' => []];
        $cumplimiento = $datos['cumplimiento'] ?? 0;
        $distribucionRiesgo = $datos['distribucion_riesgo'] ?? [];
    @endphp

    <!-- Período -->
    <div class="bg-gray-50 p-4 rounded-lg mb-6">
        <p class="text-sm text-gray-600">
            <strong>Período:</strong> {{ \Carbon\Carbon::parse($periodo['inicio'])->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($periodo['fin'])->format('d/m/Y') }}
        </p>
    </div>

    <!-- Métricas Principales -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-blue-50 p-4 rounded-lg">
            <p class="text-sm text-gray-600">Total Admisiones</p>
            <p class="text-2xl font-bold text-blue-600">{{ $admisiones['total'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Activas: {{ $admisiones['activas'] }} | Altas: {{ $admisiones['altas'] }}</p>
        </div>
        <div class="bg-red-50 p-4 rounded-lg">
            <p class="text-sm text-gray-600">Total Caídas</p>
            <p class="text-2xl font-bold text-red-600">{{ $caidas['total'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Con lesión: {{ $caidas['con_lesion'] }}</p>
        </div>
        <div class="bg-green-50 p-4 rounded-lg">
            <p class="text-sm text-gray-600">Cumplimiento Promedio</p>
            <p class="text-2xl font-bold text-green-600">{{ $cumplimiento }}%</p>
        </div>
    </div>

    <!-- Distribución por Tipo -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white border rounded-lg p-4">
            <h4 class="font-semibold text-gray-800 mb-3">Admisiones por Tipo</h4>
            @forelse($admisiones['por_tipo'] as $tipo => $cantidad)
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm">{{ $tipo === 'caida' ? 'Caídas' : 'Úlceras' }}</span>
                    <span class="font-semibold">{{ $cantidad }}</span>
                </div>
            @empty
                <p class="text-sm text-gray-500">No hay datos disponibles</p>
            @endforelse
        </div>

        <div class="bg-white border rounded-lg p-4">
            <h4 class="font-semibold text-gray-800 mb-3">Caídas por Turno</h4>
            @forelse($caidas['por_turno'] as $turno => $cantidad)
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm">{{ $turno }}</span>
                    <span class="font-semibold">{{ $cantidad }}</span>
                </div>
            @empty
                <p class="text-sm text-gray-500">No hay datos disponibles</p>
            @endforelse
        </div>
    </div>

    <!-- Distribución por Nivel de Riesgo -->
    <div class="bg-white border rounded-lg p-4">
        <h4 class="font-semibold text-gray-800 mb-3">Distribución por Nivel de Riesgo</h4>
        @if(count($distribucionRiesgo) > 0)
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($distribucionRiesgo as $nivel => $cantidad)
                    <div class="text-center p-3 rounded-lg {{ 
                        $nivel === 'Riesgo Bajo' ? 'bg-green-50' : 
                        ($nivel === 'Riesgo Moderado' ? 'bg-yellow-50' : 
                        ($nivel === 'Riesgo Alto' ? 'bg-orange-50' : 'bg-red-50')) 
                    }}">
                        <p class="text-2xl font-bold {{ 
                            $nivel === 'Riesgo Bajo' ? 'text-green-600' : 
                            ($nivel === 'Riesgo Moderado' ? 'text-yellow-600' : 
                            ($nivel === 'Riesgo Alto' ? 'text-orange-600' : 'text-red-600')) 
                        }}">{{ $cantidad }}</p>
                        <p class="text-xs text-gray-600 mt-1">{{ $nivel }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-500">No hay datos de niveles de riesgo disponibles</p>
        @endif
    </div>
</div>

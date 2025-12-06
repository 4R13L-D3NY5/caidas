<div>
    @php
        $estadisticas = $datos['estadisticas'] ?? ['total_verificaciones' => 0, 'promedio_cumplimiento' => 0, 'cumplimiento_alto' => 0, 'cumplimiento_medio' => 0, 'cumplimiento_bajo' => 0];
        $listas = $datos['listas'] ?? collect();
    @endphp

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-50 p-4 rounded-lg">
            <p class="text-sm text-gray-600">Total Verificaciones</p>
            <p class="text-2xl font-bold text-blue-600">{{ $estadisticas['total_verificaciones'] }}</p>
        </div>
        <div class="bg-green-50 p-4 rounded-lg">
            <p class="text-sm text-gray-600">Promedio Cumplimiento</p>
            <p class="text-2xl font-bold text-green-600">{{ number_format($estadisticas['promedio_cumplimiento'], 1) }}%</p>
        </div>
        <div class="bg-yellow-50 p-4 rounded-lg">
            <p class="text-sm text-gray-600">Cumplimiento Alto (≥80%)</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $estadisticas['cumplimiento_alto'] }}</p>
        </div>
        <div class="bg-red-50 p-4 rounded-lg">
            <p class="text-sm text-gray-600">Cumplimiento Bajo (<60%)</p>
            <p class="text-2xl font-bold text-red-600">{{ $estadisticas['cumplimiento_bajo'] }}</p>
        </div>
    </div>

    <!-- Tabla de Cumplimiento -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paciente</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Supervisor</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cumplimiento</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Observaciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($listas as $lista)
                    <tr>
                        <td class="px-4 py-3 text-sm">{{ $lista->fecha_verificacion->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3 text-sm">{{ $lista->admision->paciente->nombre }}</td>
                        <td class="px-4 py-3 text-sm">{{ $lista->supervisor->name }}</td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex items-center gap-2">
                                <div class="flex-1 bg-gray-200 rounded-full h-2">
                                    <div class="h-2 rounded-full {{ $lista->porcentaje_cumplimiento >= 80 ? 'bg-green-600' : ($lista->porcentaje_cumplimiento >= 60 ? 'bg-yellow-600' : 'bg-red-600') }}" 
                                        style="width: {{ $lista->porcentaje_cumplimiento }}%"></div>
                                </div>
                                <span class="font-semibold">{{ $lista->porcentaje_cumplimiento }}%</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm">{{ $lista->observaciones ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-3 text-sm text-gray-500 text-center">No se encontraron verificaciones con los filtros seleccionados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

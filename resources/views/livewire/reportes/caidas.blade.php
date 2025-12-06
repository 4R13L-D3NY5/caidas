<div>
    @php
        $estadisticas = $datos['estadisticas'] ?? ['total' => 0, 'con_lesion' => 0];
        $caidas = $datos['caidas'] ?? collect();
    @endphp

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-red-50 p-4 rounded-lg">
            <p class="text-sm text-gray-600">Total de Caídas</p>
            <p class="text-2xl font-bold text-red-600">{{ $estadisticas['total'] }}</p>
        </div>
        <div class="bg-orange-50 p-4 rounded-lg">
            <p class="text-sm text-gray-600">Con Lesión</p>
            <p class="text-2xl font-bold text-orange-600">{{ $estadisticas['con_lesion'] }}</p>
        </div>
        <div class="bg-blue-50 p-4 rounded-lg">
            <p class="text-sm text-gray-600">% Con Lesión</p>
            <p class="text-2xl font-bold text-blue-600">
                {{ $estadisticas['total'] > 0 ? round(($estadisticas['con_lesion'] / $estadisticas['total']) * 100, 1) : 0 }}%
            </p>
        </div>
        <div class="bg-purple-50 p-4 rounded-lg">
            <p class="text-sm text-gray-600">Sin Lesión</p>
            <p class="text-2xl font-bold text-purple-600">{{ $estadisticas['total'] - $estadisticas['con_lesion'] }}</p>
        </div>
    </div>

    <!-- Tabla de Caídas -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paciente</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Turno</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hora</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lugar</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lesión</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($caidas as $caida)
                    <tr>
                        <td class="px-4 py-3 text-sm">{{ $caida->fecha->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-sm">{{ $caida->admision->paciente->nombre }}</td>
                        <td class="px-4 py-3 text-sm">{{ $caida->turno }}</td>
                        <td class="px-4 py-3 text-sm">{{ $caida->hora_caida }}</td>
                        <td class="px-4 py-3 text-sm">{{ $caida->lugar }}</td>
                        <td class="px-4 py-3 text-sm">{{ $caida->tipo_caida }}</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 rounded text-xs {{ $caida->hubo_lesion ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ $caida->hubo_lesion ? 'Sí' : 'No' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-3 text-sm text-gray-500 text-center">No se encontraron caídas con los filtros seleccionados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

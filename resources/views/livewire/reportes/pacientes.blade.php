<div class="overflow-x-auto">
    <p class="text-sm text-gray-600 mb-4">Total de pacientes: <strong>{{ $datos->count() }}</strong></p>
    
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paciente</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Matrícula</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nivel de Riesgo</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Ingreso</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($datos as $admision)
                @php
                    $valoracion = $admision->valoraciones->where('tipo_valoracion', 'inicial')->first();
                @endphp
                <tr>
                    <td class="px-4 py-3 text-sm">{{ $admision->paciente->nombre }}</td>
                    <td class="px-4 py-3 text-sm">{{ $admision->paciente->matricula }}</td>
                    <td class="px-4 py-3 text-sm">{{ $admision->tipo === 'caida' ? 'Caídas' : 'Úlceras' }}</td>
                    <td class="px-4 py-3 text-sm">
                        <span class="px-2 py-1 rounded text-xs {{ $admision->estado === 'activo' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                            {{ ucfirst($admision->estado) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm">
                        @if($valoracion)
                            <span class="px-2 py-1 rounded text-xs font-semibold" 
                                style="background-color: {{ $valoracion->nivelRiesgo->codigo_color }}20; color: {{ $valoracion->nivelRiesgo->codigo_color }}">
                                {{ $valoracion->nivelRiesgo->nombre }}
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm">{{ $admision->fecha_valoracion->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-3 text-sm text-gray-500 text-center">No se encontraron pacientes con los filtros seleccionados</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

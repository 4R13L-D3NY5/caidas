<div class="max-w-5xl mx-auto py-8 px-4">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Lista de Cotejo - Verificación de Acciones</h2>
            <p class="text-gray-600 mt-2">
                Paciente: <span class="font-semibold">{{ $admision->paciente->nombre }}</span>
            </p>
            <p class="text-gray-600">
                Seguimiento: <span class="font-semibold">{{ $seguimientoDiario->fecha->format('d/m/Y') }} - {{ $seguimientoDiario->turno }}</span>
            </p>
        </div>

        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit="guardar">
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Verificación *</label>
                <input type="date" wire:model="fecha_verificacion" 
                    class="w-full max-w-xs px-3 py-2 border border-gray-300 rounded-md">
                @error('fecha_verificacion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Acciones Recomendadas</h3>
                <p class="text-sm text-gray-600 mb-4">
                    Marque las acciones que fueron aplicadas correctamente durante el turno.
                </p>

                <div class="space-y-3">
                    @foreach($accionesRecomendadas as $accion)
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                            <div class="flex items-start gap-3">
                                <input type="checkbox" 
                                    wire:model="accionesAplicadas.{{ $accion->id }}" 
                                    value="1"
                                    class="mt-1">
                                <div class="flex-1">
                                    <p class="text-gray-800 font-medium">{{ $accion->descripcion }}</p>
                                    <div class="mt-2">
                                        <label class="block text-sm text-gray-600 mb-1">Observación (opcional)</label>
                                        <input type="text" 
                                            wire:model="observaciones.{{ $accion->id }}"
                                            placeholder="Agregar nota..."
                                            class="w-full px-3 py-1 text-sm border border-gray-300 rounded">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Resumen -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-gray-700">
                    <span class="font-semibold">Total de acciones:</span> {{ $accionesRecomendadas->count() }}
                </p>
                <p class="text-sm text-gray-700">
                    <span class="font-semibold">Acciones marcadas:</span> {{ count(array_filter($accionesAplicadas)) }}
                </p>
            </div>

            <!-- Botones -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('paciente.dashboard', ['admision' => $admision->id]) }}" 
                    class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Cancelar
                </a>
                <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Guardar Verificación
                </button>
            </div>
        </form>
    </div>
</div>

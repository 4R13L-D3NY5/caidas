<div class="max-w-5xl mx-auto py-8 px-4">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                {{ $tipoValoracion === 'inicial' ? 'Valoración Inicial' : 'Valoración de Alta' }}
            </h2>
            <p class="text-gray-600 mt-2">
                Paciente: <span class="font-semibold">{{ $admision->paciente->nombre }}</span> 
                ({{ $admision->paciente->matricula }})
            </p>
            <p class="text-gray-600">
                Tipo: <span class="font-semibold">{{ $admision->tipo === 'caida' ? 'Caídas' : 'Úlceras por Presión' }}</span>
            </p>
        </div>

        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit="guardarValoracion">
            <div class="space-y-6">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">{{ $escala->nombre }}</h3>

                @foreach($items as $item)
                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                        <div class="mb-3">
                            <h4 class="font-semibold text-gray-800">
                                {{ $item->numero }}. {{ $item->nombre }}
                            </h4>
                            @if($item->descripcion)
                                <p class="text-sm text-gray-600 mt-1">{{ $item->descripcion }}</p>
                            @endif
                        </div>

                        <div class="space-y-2">
                            @foreach($item->opciones as $opcion)
                                <label class="flex items-start p-3 border border-gray-300 rounded-md hover:bg-white cursor-pointer transition">
                                    <input type="radio" 
                                        wire:model="respuestas.{{ $item->id }}" 
                                        value="{{ $opcion->id }}"
                                        class="mt-1 mr-3">
                                    <div class="flex-1">
                                        <span class="text-gray-800">{{ $opcion->criterio }}</span>
                                        <span class="ml-2 text-sm font-semibold text-blue-600">({{ $opcion->puntaje }} pts)</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                @error('respuestas')
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Botones -->
            <div class="flex justify-end gap-3 mt-8">
                <a href="{{ route('dashboard') }}" 
                    class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Cancelar
                </a>
                <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Guardar Valoración
                </button>
            </div>
        </form>
    </div>
</div>

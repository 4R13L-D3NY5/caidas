<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Seguimiento Diario</h2>
            <p class="text-gray-600 mt-2">
                Paciente: <span class="font-semibold">{{ $admision->paciente->nombre }}</span>
            </p>
        </div>

        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit="guardar">
            <!-- Datos básicos -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha *</label>
                    <input type="date" wire:model="fecha" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('fecha') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Turno *</label>
                    <select wire:model="turno" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Seleccione...</option>
                        <option value="Mañana">Mañana</option>
                        <option value="Tarde">Tarde</option>
                        <option value="Noche 1">Noche 1</option>
                        <option value="Noche 2">Noche 2</option>
                        <option value="Noche 3">Noche 3</option>
                        <option value="Feriados">Feriados</option>
                    </select>
                    @error('turno') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Pregunta principal -->
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <label class="block text-lg font-semibold text-gray-800 mb-3">
                    ¿Hubo alguna caída durante el turno? *
                </label>
                <div class="flex gap-4">
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" wire:model.live="hubo_caida" value="0" class="mr-2">
                        <span class="text-gray-700 font-medium">No</span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" wire:model.live="hubo_caida" value="1" class="mr-2">
                        <span class="text-gray-700 font-medium">Sí</span>
                    </label>
                </div>
            </div>

            @if(!$hubo_caida && $hubo_caida !== '')
                <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg mb-6">
                    <p class="font-semibold">✓ Sin evento de caídas durante 24 horas</p>
                </div>
            @endif

            <!-- Formulario de caída (solo si hubo caída) -->
            @if($hubo_caida)
                <div class="space-y-4 mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <h3 class="text-lg font-semibold text-red-800 mb-4">Detalles de la Caída</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Hora de la caída ⏰ *</label>
                            <input type="time" wire:model="hora_caida" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            @error('hora_caida') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Lugar 🏥 *</label>
                            <select wire:model="lugar" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                <option value="">Seleccione...</option>
                                @foreach($opcionesLugar as $opcion)
                                    <option value="{{ $opcion }}">{{ $opcion }}</option>
                                @endforeach
                            </select>
                            @error('lugar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de caída *</label>
                            <select wire:model="tipo_caida" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                <option value="">Seleccione...</option>
                                @foreach($opcionesTipoCaida as $opcion)
                                    <option value="{{ $opcion }}">{{ $opcion }}</option>
                                @endforeach
                            </select>
                            @error('tipo_caida') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">¿Hubo lesión? *</label>
                            <div class="flex gap-4 mt-2">
                                <label class="flex items-center">
                                    <input type="radio" wire:model.live="hubo_lesion" value="1" class="mr-2"> Sí
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" wire:model.live="hubo_lesion" value="0" class="mr-2"> No
                                </label>
                            </div>
                            @error('hubo_lesion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    @if($hubo_lesion)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Descripción breve de la lesión *</label>
                            <textarea wire:model="descripcion_lesion" rows="2"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
                            @error('descripcion_lesion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Acciones tomadas</label>
                        <div class="space-y-2">
                            @foreach($opcionesAcciones as $accion)
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="acciones_tomadas" value="{{ $accion }}" class="mr-2">
                                    {{ $accion }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Observación</label>
                        <textarea wire:model="observacion" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
                    </div>
                </div>
            @endif

            <!-- Botones -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('paciente.dashboard', ['admision' => $admision->id]) }}" 
                    class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Cancelar
                </a>
                <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Guardar Seguimiento
                </button>
            </div>
        </form>
    </div>
</div>

<div>
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            Seguimiento Diario - {{ $admision->paciente->nombre }}
        </h2>

        <div class="mb-4 p-4 bg-blue-50 rounded-lg">
            <p class="text-sm text-gray-700">
                <strong>Tipo de Admisión:</strong> {{ $tipoAdmision === 'caida' ? 'Caídas' : 'Úlceras por Presión' }}
            </p>
            <p class="text-sm text-gray-700">
                <strong>Matrícula:</strong> {{ $admision->paciente->matricula }}
            </p>
        </div>

        @if (session()->has('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit.prevent="guardar">
            <!-- Campos Comunes -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha *</label>
                    <input type="date" wire:model="fecha" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                    @error('fecha') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Turno *</label>
                    <select wire:model="turno" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                        <option value="">Seleccione un turno</option>
                        <option value="Mañana">Mañana</option>
                        <option value="Tarde">Tarde</option>
                        <option value="Noche 1">Noche 1</option>
                        <option value="Noche 2">Noche 2</option>
                        <option value="Noche 3">Noche 3</option>
                    </select>
                    @error('turno') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            @if($tipoAdmision === 'caida')
                <!-- Formulario para Caídas -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Registro de Caídas</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Hubo alguna caída durante el turno? *</label>
                        <div class="flex gap-6">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" wire:model="hubo_caida" value="1" class="mr-2">
                                <span class="text-sm text-gray-700">Sí</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" wire:model="hubo_caida" value="0" class="mr-2">
                                <span class="text-sm text-gray-700">No</span>
                            </label>
                        </div>
                    </div>

                    @if($hubo_caida === '1' || $hubo_caida === 1 || $hubo_caida === true)
                        <div class="space-y-4 pl-6 border-l-4 border-red-500">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Hora de la Caída *</label>
                                    <input type="time" wire:model="hora_caida" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                                    @error('hora_caida') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Lugar *</label>
                                    <select wire:model="lugar" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                                        <option value="">Seleccione</option>
                                        <option value="Cama">Cama</option>
                                        <option value="Baño">Baño</option>
                                        <option value="Pasillo">Pasillo</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                    @error('lugar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Caída *</label>
                                <select wire:model="tipo_caida" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                                    <option value="">Seleccione</option>
                                    <option value="Caída propia altura">Caída propia altura</option>
                                    <option value="Desde cama">Desde cama</option>
                                    <option value="Desde silla">Desde silla</option>
                                    <option value="Otro">Otro</option>
                                </select>
                                @error('tipo_caida') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">¿Hubo lesión? *</label>
                                <div class="flex gap-6">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="radio" wire:model="hubo_lesion" value="1" class="mr-2">
                                        <span class="text-sm text-gray-700">Sí</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer">
                                        <input type="radio" wire:model="hubo_lesion" value="0" class="mr-2">
                                        <span class="text-sm text-gray-700">No</span>
                                    </label>
                                </div>
                            </div>

                            @if($hubo_lesion === '1' || $hubo_lesion === 1 || $hubo_lesion === true)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Descripción de la Lesión *</label>
                                    <textarea wire:model="descripcion_lesion" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-md" required></textarea>
                                    @error('descripcion_lesion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones</label>
                                <textarea wire:model="observacion" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-md"></textarea>
                            </div>
                        </div>
                    @elseif($hubo_caida === '0' || $hubo_caida === 0 || $hubo_caida === false)
                        <div class="p-4 bg-green-50 border border-green-200 rounded-md">
                            <p class="text-sm text-green-700">✓ Sin eventos de caídas durante las 24 horas</p>
                        </div>
                    @endif
                </div>

            @else
                <!-- Formulario para Úlceras -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Registro de Úlceras por Presión</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Hubo algún caso de úlceras durante el turno? *</label>
                        <div class="flex gap-6">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" wire:model="hubo_ulcera" value="1" class="mr-2">
                                <span class="text-sm text-gray-700">Sí</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" wire:model="hubo_ulcera" value="0" class="mr-2">
                                <span class="text-sm text-gray-700">No</span>
                            </label>
                        </div>
                    </div>

                    @if($hubo_ulcera === '1' || $hubo_ulcera === 1 || $hubo_ulcera === true)
                        <div class="space-y-4 pl-6 border-l-4 border-orange-500">
                            <!-- Pregunta 1: Estadio -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Estadio - Descripción Clínica (terminología enfermería) *</label>
                                <select wire:model="estado_ulcera" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                                    <option value="">Seleccione un estadio</option>
                                    <option value="Estado I">Estado I - Eritema en piel íntegra</option>
                                    <option value="Estado II">Estado II - Pérdida parcial del espesor cutáneo (epidermis/dermis). Se presenta como abrasión, flictena o úlcera superficial</option>
                                    <option value="Estado III">Estado III - Pérdida total del espesor cutáneo con afectación de tejido subcutáneo. Puede haber cavidad, socavamiento y tejido de granulación</option>
                                    <option value="Estado IV">Estado IV - Pérdida total del espesor con exposición de músculo, hubo o estructuras de soporte</option>
                                </select>
                                @error('estado_ulcera') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Pregunta 2: Frecuente presencia de necrosis -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Frecuente presencia de necrosis *</label>
                                <div class="space-y-2">
                                    <label class="flex items-start cursor-pointer p-3 border border-gray-300 rounded-md hover:bg-gray-50">
                                        <input type="radio" wire:model="presencia_necrosis" value="No clasificable" class="mt-1 mr-3">
                                        <div>
                                            <div class="font-medium text-sm text-gray-900">No clasificable</div>
                                            <div class="text-xs text-gray-600">Profundidad no determinable por presencia de esfacelos o escara que cubren la base de la lesión</div>
                                        </div>
                                    </label>
                                    <label class="flex items-start cursor-pointer p-3 border border-gray-300 rounded-md hover:bg-gray-50">
                                        <input type="radio" wire:model="presencia_necrosis" value="Lesión de tejido profundo" class="mt-1 mr-3">
                                        <div>
                                            <div class="font-medium text-sm text-gray-900">Lesión de tejido profundo</div>
                                            <div class="text-xs text-gray-600">Piel íntegra o con flictena hemática, color morado/borgoña</div>
                                        </div>
                                    </label>
                                </div>
                                @error('presencia_necrosis') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ubicación de la Úlcera *</label>
                                <input type="text" wire:model="ubicacion_ulcera" class="w-full px-4 py-2 border border-gray-300 rounded-md" 
                                    placeholder="Ej: Sacro, talón derecho, etc." required>
                                @error('ubicacion_ulcera') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Descripción Clínica *</label>
                                <textarea wire:model="descripcion_ulcera" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-md" 
                                    placeholder="Describa las características observadas..." required></textarea>
                                @error('descripcion_ulcera') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones Adicionales</label>
                                <textarea wire:model="observaciones_ulcera" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-md"
                                    placeholder="Acciones tomadas, tratamiento aplicado, etc."></textarea>
                            </div>
                        </div>
                    @elseif($hubo_ulcera === '0' || $hubo_ulcera === 0 || $hubo_ulcera === false)
                        <div class="p-4 bg-green-50 border border-green-200 rounded-md">
                            <p class="text-sm text-green-700">✓ Sin eventos de úlceras durante las 24 horas</p>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Botones -->
            <div class="flex justify-end gap-4 mt-6 pt-6 border-t">
                <a href="{{ route('paciente.dashboard', $admisionId) }}" 
                    class="px-6 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Guardar Seguimiento
                </button>
            </div>
        </form>
    </div>
</div>

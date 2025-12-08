<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Registro de Paciente</h2>

        @if (session()->has('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- Paso 1: Búsqueda por Matrícula -->
        @if(!$mostrarFormulario)
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Buscar Paciente por Matrícula</h3>
                <div class="flex gap-4 items-end">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Matrícula <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                            wire:model="matricula" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Ingrese la matrícula del paciente"
                            wire:keydown.enter="buscarPaciente">
                        @error('matricula') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <button type="button" 
                        wire:click="buscarPaciente"
                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-semibold">
                        Buscar
                    </button>
                </div>
                <p class="text-sm text-gray-500 mt-2">
                    Ingrese la matrícula para buscar si el paciente ya está registrado
                </p>
            </div>
        @endif

        <!-- Paso 2: Formulario Completo -->
        @if($mostrarFormulario)
            <form wire:submit.prevent="guardar">
                <!-- Mensaje de paciente encontrado -->
                @if($pacienteEncontrado)
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-green-800">Paciente Encontrado</p>
                                <p class="text-sm text-green-700">Los datos del paciente han sido cargados.</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-blue-800">Nuevo Paciente</p>
                                <p class="text-sm text-blue-700">Complete los datos para registrar un nuevo paciente.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Datos del Paciente -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Datos del Paciente</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre Completo <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                wire:model="nombre"
                                wire:key="nombre-{{ $pacienteEncontrado ? $pacienteEncontrado->id : 'new' }}"
                                value="{{ $this->nombre }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 {{ $pacienteEncontrado ? 'bg-gray-100' : '' }}"
                                {{ $pacienteEncontrado ? 'readonly' : '' }}>
                            @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Matrícula <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                wire:model="matricula" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md {{ $pacienteEncontrado ? 'bg-gray-100' : '' }}"
                                readonly>
                            @error('matricula') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Fecha de Nacimiento <span class="text-red-500">*</span>
                            </label>
                            <input type="date" 
                                wire:model="fecha_nacimiento" 
                                wire:key="fecha-{{ $pacienteEncontrado ? $pacienteEncontrado->id : 'new' }}"
                                value="{{ $this->fecha_nacimiento }}"
                                max="{{ now()->format('Y-m-d') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 {{ $pacienteEncontrado ? 'bg-gray-100' : '' }}"
                                {{ $pacienteEncontrado ? 'readonly' : '' }}>
                            @error('fecha_nacimiento') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Datos de Admisión -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Datos de Admisión</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Motivo de Ingreso <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="tipo" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="caida">Caídas</option>
                                <option value="ulcera">Úlceras por Presión</option>
                            </select>
                            @error('tipo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Turno <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="turno" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Fecha de Valoración <span class="text-red-500">*</span>
                            </label>
                            <input type="date" 
                                wire:model="fecha_valoracion" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('fecha_valoracion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Diagnóstico Inicial <span class="text-red-500">*</span>
                        </label>
                        <textarea wire:model="diagnostico_inicial" 
                            rows="3" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Describa el diagnóstico inicial del paciente"></textarea>
                        @error('diagnostico_inicial') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex justify-end gap-4">
                    <button type="button" 
                        wire:click="cancelar"
                        class="px-6 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Cancelar
                    </button>
                    <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-semibold">
                        Registrar y Continuar a Valoración
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>

<div>
    <!-- Selector de Tipo de Reporte -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Seleccione el Tipo de Reporte</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <button wire:click="$set('tipoReporte', 'pacientes')" 
                class="p-4 rounded-lg border-2 transition {{ $tipoReporte === 'pacientes' ? 'border-blue-600 bg-blue-50' : 'border-gray-300 hover:border-blue-400' }}">
                <svg class="w-8 h-8 mx-auto mb-2 {{ $tipoReporte === 'pacientes' ? 'text-blue-600' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <p class="font-semibold">Pacientes</p>
            </button>

            <button wire:click="$set('tipoReporte', 'caidas')" 
                class="p-4 rounded-lg border-2 transition {{ $tipoReporte === 'caidas' ? 'border-red-600 bg-red-50' : 'border-gray-300 hover:border-red-400' }}">
                <svg class="w-8 h-8 mx-auto mb-2 {{ $tipoReporte === 'caidas' ? 'text-red-600' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <p class="font-semibold">Caídas</p>
            </button>

            <button wire:click="$set('tipoReporte', 'cumplimiento')" 
                class="p-4 rounded-lg border-2 transition {{ $tipoReporte === 'cumplimiento' ? 'border-green-600 bg-green-50' : 'border-gray-300 hover:border-green-400' }}">
                <svg class="w-8 h-8 mx-auto mb-2 {{ $tipoReporte === 'cumplimiento' ? 'text-green-600' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="font-semibold">Cumplimiento</p>
            </button>

            <button wire:click="$set('tipoReporte', 'estadistico')" 
                class="p-4 rounded-lg border-2 transition {{ $tipoReporte === 'estadistico' ? 'border-purple-600 bg-purple-50' : 'border-gray-300 hover:border-purple-400' }}">
                <svg class="w-8 h-8 mx-auto mb-2 {{ $tipoReporte === 'estadistico' ? 'text-purple-600' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <p class="font-semibold">Estadístico</p>
            </button>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Filtros</h3>
        
        <!-- Filtros Comunes -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Inicio</label>
                <input type="date" wire:model="fecha_inicio" class="w-full px-4 py-2 border border-gray-300 rounded-md">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Fin</label>
                <input type="date" wire:model="fecha_fin" class="w-full px-4 py-2 border border-gray-300 rounded-md">
            </div>
        </div>

        <!-- Filtros Específicos de Pacientes -->
        @if($tipoReporte === 'pacientes')
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                    <select wire:model="estado" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                        <option value="todos">Todos</option>
                        <option value="activo">Activos</option>
                        <option value="alta">De Alta</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo</label>
                    <select wire:model="tipo" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                        <option value="todos">Todos</option>
                        <option value="caida">Caídas</option>
                        <option value="ulcera">Úlceras</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nivel de Riesgo</label>
                    <select wire:model="nivel_riesgo" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                        <option value="">Todos</option>
                        <option value="Riesgo Bajo">Bajo</option>
                        <option value="Riesgo Moderado">Moderado</option>
                        <option value="Riesgo Alto">Alto</option>
                        <option value="Riesgo Muy Alto">Muy Alto</option>
                    </select>
                </div>
            </div>
        @endif

        <!-- Filtros Específicos de Caídas -->
        @if($tipoReporte === 'caidas')
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Turno</label>
                    <select wire:model="turno" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                        <option value="todos">Todos</option>
                        <option value="Mañana">Mañana</option>
                        <option value="Tarde">Tarde</option>
                        <option value="Noche 1">Noche 1</option>
                        <option value="Noche 2">Noche 2</option>
                        <option value="Noche 3">Noche 3</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Caída</label>
                    <select wire:model="tipo_caida" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                        <option value="todos">Todos</option>
                        <option value="Caída propia altura">Propia altura</option>
                        <option value="Desde cama">Desde cama</option>
                        <option value="Desde silla">Desde silla</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Con Lesión</label>
                    <select wire:model="con_lesion" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                        <option value="">Todas</option>
                        <option value="1">Con lesión</option>
                        <option value="0">Sin lesión</option>
                    </select>
                </div>
            </div>
        @endif

        <!-- Filtros Específicos de Cumplimiento -->
        @if($tipoReporte === 'cumplimiento')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Supervisor</label>
                    <select wire:model="supervisor_id" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                        <option value="">Todos</option>
                        @foreach($supervisores as $supervisor)
                            <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cumplimiento Mínimo (%)</label>
                    <input type="number" wire:model="cumplimiento_minimo" min="0" max="100" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Ej: 70">
                </div>
            </div>
        @endif

        <!-- Filtros Específicos de Estadístico -->
        @if($tipoReporte === 'estadistico')
            <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Admisión</label>
                    <select wire:model="tipo" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                        <option value="todos">Todos</option>
                        <option value="caida">Caídas</option>
                        <option value="ulcera">Úlceras</option>
                    </select>
                </div>
            </div>
        @endif

        <!-- Botones de Acción -->
        <div class="flex justify-end gap-4 mt-6">
            <button wire:click="limpiarFiltros" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                Limpiar Filtros
            </button>
            <button wire:click="generarReporte" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Generar Reporte
            </button>
        </div>
    </div>

    <!-- Resultados y Exportación -->
    @if($mostrarResultados && $datos)
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Resultados del Reporte</h3>
                
                <!-- Botón de Exportar PDF -->
                <form action="{{ route('reportes.' . $tipoReporte . '.pdf') }}" method="POST" target="_blank">
                    @csrf
                    <input type="hidden" name="fecha_inicio" value="{{ $fecha_inicio }}">
                    <input type="hidden" name="fecha_fin" value="{{ $fecha_fin }}">
                    @if($tipoReporte === 'pacientes')
                        <input type="hidden" name="estado" value="{{ $estado }}">
                        <input type="hidden" name="tipo" value="{{ $tipo }}">
                        <input type="hidden" name="nivel_riesgo" value="{{ $nivel_riesgo }}">
                    @elseif($tipoReporte === 'caidas')
                        <input type="hidden" name="turno" value="{{ $turno }}">
                        <input type="hidden" name="tipo_caida" value="{{ $tipo_caida }}">
                        <input type="hidden" name="con_lesion" value="{{ $con_lesion }}">
                    @elseif($tipoReporte === 'cumplimiento')
                        <input type="hidden" name="supervisor_id" value="{{ $supervisor_id }}">
                        <input type="hidden" name="cumplimiento_minimo" value="{{ $cumplimiento_minimo }}">
                    @elseif($tipoReporte === 'estadistico')
                        <input type="hidden" name="tipo" value="{{ $tipo }}">
                    @endif
                    
                    <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Exportar PDF
                    </button>
                </form>
            </div>

            <!-- Vista Previa según tipo de reporte -->
            @include('livewire.reportes.' . $tipoReporte)
        </div>
    @endif
</div>

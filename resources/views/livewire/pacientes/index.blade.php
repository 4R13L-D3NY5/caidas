<div class="max-w-7xl mx-auto py-8 px-4">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Gestión de Pacientes</h2>
        </div>

        <!-- Buscador -->
        <div class="mb-4">
            <input type="text" 
                wire:model.live.debounce.300ms="search"
                placeholder="Buscar por nombre o matrícula..." 
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        @if (session()->has('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Tabla -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Matrícula</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Edad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Nacimiento</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($pacientes as $paciente)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $paciente->matricula }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $paciente->nombre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $paciente->edad }} años</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $paciente->fecha_nacimiento ? $paciente->fecha_nacimiento->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="editar({{ $paciente->id }})" class="text-indigo-600 hover:text-indigo-900">Editar</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No se encontraron pacientes.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $pacientes->links() }}
        </div>
    </div>

    <!-- Modal de Edición -->
    @if($mostrarModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none bg-gray-900 bg-opacity-50">
            <div class="relative w-full max-w-lg mx-auto my-6">
                <!--content-->
                <div class="relative flex flex-col w-full bg-white border-0 rounded-lg shadow-lg outline-none focus:outline-none">
                    <!--header-->
                    <div class="flex items-start justify-between p-5 border-b border-solid border-gray-200 rounded-t">
                        <h3 class="text-xl font-semibold">
                            Editar Paciente
                        </h3>
                        <button class="p-1 ml-auto bg-transparent border-0 text-gray-300 opacity-50 float-right text-3xl leading-none font-semibold outline-none focus:outline-none" wire:click="cerrarModal">
                            <span class="bg-transparent text-gray-500 h-6 w-6 text-2xl block outline-none focus:outline-none">×</span>
                        </button>
                    </div>
                    <!--body-->
                    <div class="relative p-6 flex-auto">
                        <form wire:submit.prevent="actualizar">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="nombre">
                                    Nombre Completo
                                </label>
                                <input wire:model="nombre" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nombre" type="text">
                                @error('nombre') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="matricula">
                                    Matrícula
                                </label>
                                <input wire:model="matricula" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="matricula" type="text">
                                @error('matricula') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="fecha_nacimiento">
                                    Fecha de Nacimiento
                                </label>
                                <input wire:model="fecha_nacimiento" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="fecha_nacimiento" type="date" max="{{ now()->format('Y-m-d') }}">
                                @error('fecha_nacimiento') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                            </div>
                        
                            <div class="flex items-center justify-end p-6 border-t border-solid border-gray-200 rounded-b">
                                <button class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" wire:click="cerrarModal">
                                    Cancelar
                                </button>
                                <button class="bg-blue-500 text-white active:bg-blue-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="submit">
                                    Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

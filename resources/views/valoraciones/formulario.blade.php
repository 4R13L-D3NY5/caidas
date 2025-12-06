<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $tipo === 'inicial' ? 'Valoración Inicial' : 'Valoración de Alta' }}
        </h2>
    </x-slot>

    <livewire:formulario-valoracion :admisionId="$admisionId" :tipo="$tipo" />
</x-app-layout>

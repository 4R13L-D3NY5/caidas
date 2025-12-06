<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Historial de Internación') }}
        </h2>
    </x-slot>

    <livewire:historial-impresion :admisionId="$admisionId" />
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard del Paciente') }}
        </h2>
    </x-slot>

    <livewire:dashboard-paciente :admisionId="$admisionId" />
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laptop manager') }}
        </h2>
    </x-slot>

    <div>
        <h1>Laptop</h1>
        <livewire:laptop-manager/>
        @livewireScripts
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Exchanges') }}
        </h2>
    </x-slot>

    <livewire:exchanges-table/>

</x-app-layout>

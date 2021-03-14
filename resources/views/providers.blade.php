<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Providers') }}
        </h2>
    </x-slot>

    <livewire:providers-table/>

</x-app-layout>

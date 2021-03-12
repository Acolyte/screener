<x-app-layout>
    <x-slot name="header"
    ">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Stocks') }}
    </h2>
    </x-slot>

    <x-dashboard>
        <livewire:stock position="a1"/>
        <livewire:stock position="b1"/>
        <livewire:stock position="c1"/>
    </x-dashboard>
</x-app-layout>



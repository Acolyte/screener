<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Providers') }}
        </h2>
    </x-slot>

    <livewire:datatable model="App\Models\Provider" include="id, name, site, created_at" searchable="name, site"
                        dates="created_at"/>
</x-app-layout>

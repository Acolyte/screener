<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Exchanges') }}
        </h2>
    </x-slot>

    <livewire:datatable model="App\Models\Exchange" with="provider"
                        include="provider.name|Provider, id, code, name, created_at"
                        searchable="provider.name, code, name" dates="created_at"/>
</x-app-layout>

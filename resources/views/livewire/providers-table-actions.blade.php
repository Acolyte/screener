@if (config('app.dataprovider.default') === $code)
<button wire:click="loadExchanges('{{ $code }}')"
        class="w-1/2 flex items-center justify-center rounded-md border border-gray-300" type="button">Load exchanges
</button>
@if (session()->has('message'))
<div class="alert alert-success">
    {{ session('message') }}
</div>
@endif
@endif

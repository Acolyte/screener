<?php

namespace App\Http\Livewire;

use App\Jobs\GetExchanges;
use App\Models\Provider;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class ProvidersTable extends LivewireDatatable
{
    public $model = Provider::class;

    public function columns()
    {
        return [
            NumberColumn::name('id'),

            Column::name('code')->hide(),

            Column::name('name'),

            Column::name('site'),

            DateColumn::name('created_at'),

            Column::callback(['code'], function ($code)
            {
                return view('livewire.providers-table-actions', ['code' => $code]);
            })
        ];
    }

    public function loadExchanges(string $ProviderCode)
    {
        $Provider = Provider::query()->where('code', $ProviderCode)->firstOrFail();
        dispatch(new GetExchanges($Provider));
    }
}

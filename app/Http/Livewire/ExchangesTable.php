<?php

namespace App\Http\Livewire;

use App\Jobs\GetExchangeStocks;
use App\Models\Exchange;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class ExchangesTable extends LivewireDatatable
{
    public $model = Exchange::class;

    public function builder()
    {
        return Exchange::query()->with(['provider', 'country', 'currency']);
    }

    public function columns()
    {
        return [
            NumberColumn::name('id'),

            Column::name('provider.name')
                  ->label('Provider'),

            Column::name('code')->searchable(),
            Column::name('name')->searchable()->filterable($this->exchanges)->alignRight(),

            Column::name('mics')->searchable(),

            Column::callback(['code'], function ($code)
            {
                return view('livewire.exchanges-table-actions', ['code' => $code]);
            })
        ];
    }

    public function loadStocks(string $ExchangeCode)
    {
        $Exchange = Exchange::query()->where('code', $ExchangeCode)->firstOrFail();
        dispatch(new GetExchangeStocks($Exchange));
    }

    public function getExchangesProperty()
    {
        return Exchange::pluck('name');
    }
}

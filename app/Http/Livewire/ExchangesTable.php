<?php

namespace App\Http\Livewire;

use App\Jobs\GetExchangeStocks;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Exchange;
use App\Models\Provider;
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
                  ->label('Provider')->filterable($this->providers),

            Column::name('code')->hide(),
            Column::name('name')->searchable()->filterable($this->exchanges)->alignRight(),

            Column::name('currency.code')->label('Currency')->filterable($this->currencies)->searchable(),
            Column::name('country.name')->label('Country')->filterable($this->countries)->searchable(),

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

    public function getProvidersProperty()
    {
        return Provider::pluck('name');
    }

    public function getCurrenciesProperty()
    {
        return Currency::pluck('code');
    }

    public function getCountriesProperty()
    {
        return Country::pluck('name');
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Exchange;
use App\Models\Stock;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class StocksTable extends LivewireDatatable
{
    public $model = Stock::class;

    public function columns()
    {
        return [
            Column::name('exchange.name')->label('Exchange')->filterable($this->exchanges),

            NumberColumn::name('id'),

            Column::name('code')->searchable(),

            Column::name('type')->filterable(array_values(config('enums.stock'))),

            Column::name('name')->searchable(),

            BooleanColumn::name('active')->filterable([true => 'Yes', false => 'No']),
        ];
    }

    public function getExchangesProperty()
    {
        return Exchange::pluck('name');
    }
}

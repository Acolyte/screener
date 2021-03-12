<?php

namespace App\Exchanges\AlphaVantage;

use App\Exchanges\Exchange;
use Illuminate\Support\Collection;

class AVExchange implements Exchange
{

    public function GetExchanges() : iterable
    {
        // TODO: Implement GetExchanges() method.
    }

    public function GetStocksList($Exchange = null) : iterable
    {
        // TODO: Implement GetStocksList() method.
    }

    public function GetStockData($Stock, \DateTimeInterface $From, \DateTimeInterface $To, $Period, $Filters) : iterable
    {
        // TODO: Implement GetStockData() method.
    }
}

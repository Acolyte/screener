<?php

namespace App\Exchanges\AlphaVantage;

use App\Exchanges\Exchange;
use ArrayAccess;
use DateTimeInterface;

class AVExchange implements Exchange
{
    public function GetExchanges(): iterable
    {
        // TODO: Implement GetExchanges() method.
        return collect();
    }

    public function GetStocksList($Exchange = null): iterable
    {
        // TODO: Implement GetStocksList() method.
    }

    public function GetStockData($Stock, DateTimeInterface $Date, $Period, $Filters): ArrayAccess
    {
        // TODO: Implement GetStockData() method.
    }
}

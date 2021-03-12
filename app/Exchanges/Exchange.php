<?php

namespace App\Exchanges;

interface Exchange
{
    public function GetExchanges() : iterable;
    public function GetStocksList($Exchange = null) : iterable;
    public function GetStockData($Stock, \DateTimeInterface $From, \DateTimeInterface $To, $Period, $Filters) : iterable;
}

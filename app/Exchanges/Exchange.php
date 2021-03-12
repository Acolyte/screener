<?php

namespace App\Exchanges;

use ArrayAccess;
use DateTimeInterface;

interface Exchange
{
    public function GetExchanges(): iterable;

    public function GetStocksList($Exchange = null): iterable;

    public function GetStockData($Stock, DateTimeInterface $Date, $Period, $Filters): ArrayAccess;
}

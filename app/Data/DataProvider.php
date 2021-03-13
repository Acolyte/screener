<?php

namespace App\Data;

use DateTimeInterface;
use Traversable;

interface DataProvider
{
    public function GetExchanges(): Traversable;

    public function GetStocksList($Exchange = null): Traversable;

    public function GetStockData($Stock, DateTimeInterface $Date, $Period, $Filters): Traversable;
}

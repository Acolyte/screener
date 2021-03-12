<?php

namespace App\Data;

use ArrayAccess;
use DateTimeInterface;

interface DataProvider
{
    public function GetExchanges(): iterable;

    public function GetStocksList($Exchange = null): iterable;

    public function GetStockData($Stock, DateTimeInterface $Date, $Period, $Filters): ArrayAccess;
}

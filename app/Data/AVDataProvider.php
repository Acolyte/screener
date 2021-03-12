<?php

namespace App\Data;

use ArrayAccess;
use DateTimeInterface;

class AVDataProvider implements DataProvider
{
    public function __construct($config)
    {

    }

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

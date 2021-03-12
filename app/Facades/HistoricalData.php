<?php

namespace App\Facades;

use ArrayAccess;
use DateTimeInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static iterable GetExchanges()
 * @method static iterable GetStocksList($Exchange = null)
 * @method static ArrayAccess GetStockData($Stock, DateTimeInterface $Date, $Period, $Filters)
 */
class HistoricalData extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'historicaldata';
    }
}

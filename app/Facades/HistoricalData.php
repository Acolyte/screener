<?php

namespace App\Facades;

use DateTimeInterface;
use Illuminate\Support\Facades\Facade;
use Traversable;

/**
 * @method static Traversable GetExchanges()
 * @method static Traversable GetStocksList($Exchange = null)
 * @method static Traversable GetStockData($Stock, DateTimeInterface $Date, $Period, $Filters)
 */
class HistoricalData extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'historicaldata';
    }
}

<?php
declare(strict_types=1);

namespace App\Data;

use App\Enum\TimeframeEnum;
use DateTimeInterface;
use Traversable;

interface DataProvider
{
    public function GetExchanges(): Traversable;

    public function GetStocksList($Exchange = null): Traversable;

    public function GetStockData(\App\Models\Stock $Stock, DateTimeInterface $From, DateTimeInterface $To, TimeframeEnum $Timeframe): Traversable;
}

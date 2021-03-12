<?php

namespace App\Enum;

use Spatie\Enum\Enum;

/**
 * @method static self stock()
 * @method static self etf()
 */
class StockEnum extends Enum
{
    public const STOCK = 1;
    public const ETF   = 2;

    protected static function values(): array
    {
        return [
            'stock' => self::STOCK,
            'etf'   => self::ETF
        ];
    }
}

<?php

namespace App\Enum;

use Spatie\Enum\Enum;

/**
 * @method static self alphavantage()
 * @method static self eod()
 */
class ExchangeEnum extends Enum
{
    public const ALPHA_VANTAGE = 1;
    public const EOD = 2;

    protected static function values(): array
    {
        return [
            'alphavantage' => self::ALPHA_VANTAGE,
            'eod'          => self::EOD
        ];
    }
}

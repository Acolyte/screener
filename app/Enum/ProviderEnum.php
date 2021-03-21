<?php
declare(strict_types=1);

namespace App\Enum;

use Premier\Enum\Enum;

/**
 * @method static self alphavantage()
 * @method static self eod()
 * @method string toCode()
 */
class ProviderEnum extends Enum
{
    private const ALPHAVANTAGE = 1;
    private const EOD          = 2;

    private static array $code = [
        self::ALPHAVANTAGE => 'alphavantage',
        self::EOD          => 'eod'
    ];
}

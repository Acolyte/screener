<?php
declare(strict_types=1);

namespace App\Enum;

use Premier\Enum\Enum;

/**
 * @method static self hl()
 * @method static self hlc()
 * @method static self ohlc()
 * @method static self v()
 * @method string toCode()
 */
class AnalysisEnum extends Enum
{
    private const HL   = 1;
    private const HLC  = 2;
    private const OHLC = 3;
    private const V    = 4;

    private static array $code = [
        self::HL   => 'hl',
        self::HLC  => 'hlc',
        self::OHLC => 'ohlc',
        self::V    => 'v'
    ];
}

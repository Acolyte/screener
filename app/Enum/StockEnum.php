<?php

namespace App\Enum;

use Spatie\Enum\Enum;

/**
 * @method static self commonStock()
 * @method static self etf()
 * @method static self fund()
 * @method static self bond()
 * @method static self mutualFund()
 * @method static self preferredShare()
 * @method static self preferredStock()
 */
class StockEnum extends Enum
{
    public const COMMON_STOCK    = 1;
    public const ETF             = 2;
    public const FUND            = 3;
    public const BOND            = 4;
    public const MUTUAL_FUND     = 5;
    public const PREFERRED_SHARE = 6;
    public const PREFERRED_STOCK = 7;

    protected static function values(): array
    {
        return [
            'common_stock'    => self::COMMON_STOCK,
            'etf'             => self::ETF,
            'fund'            => self::FUND,
            'bond'            => self::BOND,
            'mutual_fund'     => self::MUTUAL_FUND,
            'preferred_share' => self::PREFERRED_SHARE,
            'preferred_stock' => self::PREFERRED_STOCK
        ];
    }
}

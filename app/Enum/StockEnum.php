<?php
declare(strict_types=1);

namespace App\Enum;

use Premier\Enum\Enum;

/**
 * @method static self commonStock()
 * @method static self etf()
 * @method static self fund()
 * @method static self bond()
 * @method static self mutualFund()
 * @method static self preferredShare()
 * @method static self preferredStock()
 * @method string toCode()
 */
class StockEnum extends Enum
{
    private const COMMON_STOCK    = 1;
    private const ETF             = 2;
    private const FUND            = 3;
    private const BOND            = 4;
    private const MUTUAL_FUND     = 5;
    private const PREFERRED_SHARE = 6;
    private const PREFERRED_STOCK = 7;

    private static array $code = [
        self::COMMON_STOCK    => 'common_stock',
        self::ETF             => 'etf',
        self::FUND            => 'fund',
        self::BOND            => 'bond',
        self::MUTUAL_FUND     => 'mutual_fund',
        self::PREFERRED_SHARE => 'preferred_share',
        self::PREFERRED_STOCK => 'preferred_stock'
    ];
}

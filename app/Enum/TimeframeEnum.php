<?php
declare(strict_types=1);

namespace App\Enum;

use Premier\Enum\Enum;

/**
 * @method static self d()
 * @method static self w()
 * @method static self m()
 * @method static self y()
 * @method string toCode()
 */
class TimeframeEnum extends Enum
{
    private const D = 1;
    private const W = 2;
    private const M = 3;
    private const Y = 4;

    private static array $code = [
        self::D => 'd',
        self::W => 'w',
        self::M => 'm',
        self::Y => 'y'
    ];
}

<?php

namespace App\Enum;

use Spatie\Enum\Enum;

/**
 * @method static self daily()
 * @method static self weekly()
 * @method static self monthly()
 * @method static self yearly()
 */
class TimeframeEnum extends Enum
{
    public const D = 1;
    public const W = 2;
    public const M = 3;
    public const Y = 4;

    protected static function values(): array
    {
        return [
            'daily'   => self::D,
            'weekly'  => self::W,
            'monthly' => self::M,
            'yearly'  => self::Y
        ];
    }
}

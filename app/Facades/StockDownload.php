<?php

declare(strict_types=1);

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool download()
 * @see \App\Services\StockDownload
 */
class StockDownload extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'stock';
    }
}

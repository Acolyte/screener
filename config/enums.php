<?php

use App\Enum\ProviderEnum;
use App\Enum\StockEnum;

return [
    'provider' => [
        'Alpha Vantage' => ProviderEnum::ALPHA_VANTAGE,
        'EOD'           => ProviderEnum::EOD
    ],
    'stock'    => [
        'Common Stock'    => StockEnum::COMMON_STOCK,
        'ETF'             => StockEnum::ETF,
        'Fund'            => StockEnum::FUND,
        'Bond'            => StockEnum::BOND,
        'Mutual fund'     => StockEnum::MUTUAL_FUND,
        'Preferred Share' => StockEnum::PREFERRED_SHARE,
        'Preferred Stock' => StockEnum::PREFERRED_STOCK
    ],
];

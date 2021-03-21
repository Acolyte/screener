<?php

use App\Enum\ProviderEnum;
use App\Enum\StockEnum;
use App\Enum\TimeframeEnum;

return [
    'provider'  => [
        'Alpha Vantage' => ProviderEnum::alphavantage()->toId(),
        'EOD'           => ProviderEnum::eod()->toId()
    ],
    'stock'     => [
        'Common Stock'    => StockEnum::commonStock()->toId(),
        'ETF'             => StockEnum::etf()->toId(),
        'Fund'            => StockEnum::fund()->toId(),
        'Bond'            => StockEnum::bond()->toId(),
        'Mutual fund'     => StockEnum::mutualFund()->toId(),
        'Preferred Share' => StockEnum::preferredShare()->toId(),
        'Preferred Stock' => StockEnum::preferredStock()->toId()
    ],
    'timeframe' => [
        'Daily'   => TimeframeEnum::d()->toId(),
        'Weekly'  => TimeframeEnum::w()->toId(),
        'Monthly' => TimeframeEnum::m()->toId(),
        'Yearly'  => TimeframeEnum::y()->toId()
    ]
];

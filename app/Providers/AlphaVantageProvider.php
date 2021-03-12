<?php

namespace App\Providers;

use App\Enum\ProviderEnum;
use App\Exchanges\AlphaVantage\AVExchange;
use App\Exchanges\Exchange;
use Illuminate\Support\ServiceProvider;

class AlphaVantageProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Exchange::class, function ($app)
        {
            return new AVExchange($app['config']['exchanges'][ProviderEnum::alphavantage()->label]);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [AVExchange::class];
    }
}

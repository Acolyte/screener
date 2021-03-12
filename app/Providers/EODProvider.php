<?php

namespace App\Providers;

use App\Enum\ProviderEnum;
use App\Exchanges\EOD\EODExchange;
use App\Exchanges\Exchange;
use Illuminate\Support\ServiceProvider;

class EODProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Exchange::class, function ($app)
        {
            return new EODExchange($app['config']['exchanges'][ProviderEnum::eod()->label]);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [EODExchange::class];
    }
}

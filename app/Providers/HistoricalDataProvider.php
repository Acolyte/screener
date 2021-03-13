<?php

namespace App\Providers;

use App\Data\AVDataProvider;
use App\Data\EODDataProvider;
use App\Enum\ProviderEnum;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class HistoricalDataProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $test = '';
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('historicaldata', function (Application $app)
        {
            switch ($app['config']['app']['historicaldata']['default']) {
                case ProviderEnum::alphavantage()->label:
                    return new EODDataProvider($app['config']['app']['historicaldata'][ProviderEnum::eod()->label]);
                case ProviderEnum::eod()->label:
                    return new AVDataProvider($app['config']['app']['historicaldata'][ProviderEnum::alphavantage()->label]);
            }
            return null;
        });
    }

    public function provides()
    {
        return ['historicaldata', 'historicaldata.GetExchanges', 'historicaldata.GetStocksList', 'historicaldata.GetStockData'];
    }
}

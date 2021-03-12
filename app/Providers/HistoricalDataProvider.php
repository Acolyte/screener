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
            switch ($app['historicaldata']['default']) {
                case ProviderEnum::alphavantage()->label:
                    return new EODDataProvider($app['historicaldata'][ProviderEnum::eod()->label]);
                case ProviderEnum::eod()->label:
                    return new AVDataProvider($app['historicaldata'][ProviderEnum::alphavantage()->label]);
            }
            return null;
        });

        $this->app->bind('historicaldata.GetExchanges', function ($app, $options)
        {
            return $app['historicaldata']->GetExchanges($options);
        });

        $this->app->bind('historicaldata.GetStocksList', function ($app, $options)
        {
            return $app['historicaldata']->GetStocksList($options);
        });

        $this->app->bind('historicaldata.GetStockData', function ($app, $options)
        {
            return $app['historicaldata']->GetStockData($options);
        });
    }

    public function provides()
    {
        return ['historicaldata', 'rcache.GetExchanges', 'rcache.GetStocksList', 'rcache.GetStockData'];
    }
}

<?php

namespace App\Providers;

use App\Data\AVDataProvider;
use App\Data\EODDataProvider;
use App\Enum\ProviderEnum;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class DataProvider extends ServiceProvider
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
        $this->app->singleton('dataprovider', function (Application $app)
        {
            switch ($app['config']['app']['dataprovider']['default']) {
                case ProviderEnum::alphavantage()->label:
                    return new AVDataProvider($app['config']['app']['dataprovider'][ProviderEnum::alphavantage()->label]);
                case ProviderEnum::eod()->label:
                    return new EODDataProvider($app['config']['app']['dataprovider'][ProviderEnum::eod()->label]);
            }
            return null;
        });
    }

    public function provides()
    {
        return ['dataprovider', 'dataprovider.GetExchanges', 'dataprovider.GetStocksList', 'dataprovider.GetStockData'];
    }
}

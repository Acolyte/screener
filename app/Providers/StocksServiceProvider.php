<?php

namespace App\Providers;

use App\Services\StockDownload;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class StocksServiceProvider extends ServiceProvider
{
    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('stock', function (Application $app)
        {
            $config = $app->make('config')->get('app')['stock'];

            return new StockDownload($config);
        });

        $this->app->bind('stock.download', function ($app, $options)
        {
            return $app['stock']->download($options);
        });
    }

    public function provides()
    {
        return ['stock', 'stocs.download'];
    }
}

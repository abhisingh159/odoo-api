<?php

namespace Codemusk\OdooApi;

use Illuminate\Support\ServiceProvider;

class OdooApiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('odooapi', function ($app) {
            return new OdooApi(
                config('odooapi.url'),
                config('odooapi.db'),
                config('odooapi.username'),
                config('odooapi.password')
            );
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/odooapi.php' => config_path('odooapi.php'),
        ], 'config');
    }
}
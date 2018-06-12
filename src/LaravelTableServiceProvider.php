<?php

namespace Hardland\Providers\LaravelTable;

use Illuminate\Support\ServiceProvider;

use Hardland\Services\LaravelTable;

class LaravelTableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'laraveltable');
    }
    public function register()
    {
        $this->app->singleton(LaravelTable::class, function ($app) {
            return new LaravelTable();
        });
    }
}

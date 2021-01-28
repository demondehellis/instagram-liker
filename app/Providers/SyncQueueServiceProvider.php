<?php

namespace App\Providers;

use App\Bus\ExtendedDispatcher;
use App\Bus\Observers\SyncJobObserver;
use Illuminate\Bus\Dispatcher as LaravelDispatcher;
use Illuminate\Support\ServiceProvider;

class SyncQueueServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->extend(LaravelDispatcher::class, function ($dispatcher, $app) {
            return new ExtendedDispatcher($app, $dispatcher);
        });
    }
    
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        SyncJobObserver::boot();
    }
}

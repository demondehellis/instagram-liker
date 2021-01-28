<?php

namespace App\Providers;

use App\Browser\Driver;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\Browser;

class BrowserServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Browser::class, function ($app) {
            return new Browser(Driver::init());
        });
    }
    
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // ...
    }
}

<?php

namespace App\Jobs\Browser;

use App\Jobs\BrowserJob;
use Exception;
use Laravel\Dusk\Browser;

class SetUpBrowserJob extends BrowserJob
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        info('Set up browser...');

        Browser::$baseUrl = env('APP_URL');

        Browser::$storeScreenshotsAt = base_path('tests/Browser/screenshots');

        Browser::$storeConsoleLogAt = base_path('tests/Browser/console');

        Browser::$storeSourceAt = base_path('tests/Browser/source');

        Browser::$userResolver = function () {
            throw new Exception('User resolver has not been set.');
        };
    }
}

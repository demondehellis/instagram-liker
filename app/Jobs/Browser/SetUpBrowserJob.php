<?php

namespace App\Jobs\Browser;

use App\Jobs\BrowserJob;
use Exception;
use Illuminate\Support\Facades\File;
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
        Browser::$baseUrl = env('APP_URL');
        
        $browserStoragePath = storage_path('browser');
        if (!file_exists($browserStoragePath)) {
            File::makeDirectory($browserStoragePath);
        }
        
        Browser::$storeScreenshotsAt = $browserStoragePath . '/screenshots';
        Browser::$storeConsoleLogAt = $browserStoragePath . '/console';
        Browser::$storeSourceAt = $browserStoragePath . '/source';
        
        Browser::$userResolver = function () {
            throw new Exception('User resolver has not been set.');
        };
    }
}

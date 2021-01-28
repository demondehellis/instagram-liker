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
        
        $this->makeBrowserStorage();
        $browserStoragePath = storage_path('browser');
        Browser::$storeScreenshotsAt = $browserStoragePath . '/screenshots';
        Browser::$storeConsoleLogAt = $browserStoragePath . '/console';
        Browser::$storeSourceAt = $browserStoragePath . '/source';
        
        Browser::$userResolver = function () {
            throw new Exception('User resolver has not been set.');
        };
    }
    
    public function makeBrowserStorage()
    {
        $dirs = [
            'screenshots',
            'console',
            'source',
        ];
        
        foreach ($dirs as $dir){
            $browserStoragePath = storage_path('browser' . DIRECTORY_SEPARATOR . $dir);
            if (!file_exists($browserStoragePath)) {
                File::makeDirectory($browserStoragePath);
            }
        }
    }
}

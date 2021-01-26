<?php

namespace App\Jobs\Browser;

use App\Jobs\BrowserJob;
use Laravel\Dusk\Concerns\ProvidesBrowser;

class TearDownBrowserJob extends BrowserJob
{
    use ProvidesBrowser;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        info('Tear down...');

        static::closeAll();

        foreach (static::$afterClassCallbacks as $callback) {
            $callback();
        }
    }

    protected function driver()
    {
        return GetDriverBrowserJob::dispatchNow();
    }
}

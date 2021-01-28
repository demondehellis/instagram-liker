<?php

namespace App\Jobs\Browser;

use App\Jobs\BrowserJob;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Concerns\ProvidesBrowser;

class TearDownBrowserJob extends BrowserJob
{
    use ProvidesBrowser;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        static::closeAll();

        foreach (static::$afterClassCallbacks as $callback) {
            $callback();
        }
    }

    protected function driver()
    {
        return app(Browser::class)->driver;
    }
}

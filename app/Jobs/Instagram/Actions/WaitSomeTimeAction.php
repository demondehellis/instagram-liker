<?php

namespace App\Jobs\Instagram\Actions;

use App\Jobs\Instagram\InstagramAction;
use Laravel\Dusk\Browser;

class WaitSomeTimeAction extends InstagramAction
{
    /**
     * Execute the job.
     *
     * @param Browser $browser
     * @return void
     */
    public function handle(Browser $browser)
    {
        $randomNumberOfMilliseconds = rand(1000, 10000);
        $browser->pause($randomNumberOfMilliseconds);
    }
}

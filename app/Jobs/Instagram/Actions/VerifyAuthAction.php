<?php

namespace App\Jobs\Instagram\Actions;

use App\Jobs\Instagram\InstagramAction;
use Exception;
use Laravel\Dusk\Browser;

class VerifyAuthAction extends InstagramAction
{
    /**
     * Execute the job.
     *
     * @param Browser $browser
     * @return void
     * @throws Exception
     */
    public function handle(Browser $browser)
    {
        $browser->visit('https://www.instagram.com/');
        $browser->waitFor('[aria-label="Direct"]');
        $browser->screenshot('auth');
    }
}

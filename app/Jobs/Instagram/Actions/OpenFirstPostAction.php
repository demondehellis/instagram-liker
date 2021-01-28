<?php

namespace App\Jobs\Instagram\Actions;

use App\Jobs\Instagram\InstagramAction;
use Laravel\Dusk\Browser;

class OpenFirstPostAction extends InstagramAction
{
    /**
     * Execute the job.
     *
     * @param Browser $browser
     * @return void
     */
    public function handle(Browser $browser)
    {
        $browser->clickAtPoint(70, 70);
        WaitForPostDialogAction::dispatchNow();
        $browser->screenshot('open-first-post');
    }
}

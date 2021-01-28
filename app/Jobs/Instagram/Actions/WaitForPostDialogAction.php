<?php

namespace App\Jobs\Instagram\Actions;

use App\Jobs\Instagram\InstagramAction;
use Laravel\Dusk\Browser;

class WaitForPostDialogAction extends InstagramAction
{
    /**
     * Execute the job.
     *
     * @param Browser $browser
     * @return void
     */
    public function handle(Browser $browser)
    {
        info('Wait for post dialog ' . $browser->driver->getCurrentURL());
        $browser->waitFor('[role="dialog"] article header', 30);
        $browser->screenshot('wait-for-post-dialog');
    }
}

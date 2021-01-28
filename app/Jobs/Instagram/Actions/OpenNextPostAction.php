<?php

namespace App\Jobs\Instagram\Actions;

use App\Jobs\Instagram\InstagramAction;
use App\Jobs\Instagram\Scripts\SendKeyUpEventScript;
use Laravel\Dusk\Browser;

class OpenNextPostAction extends InstagramAction
{
    /**
     * Execute the job.
     *
     * @param Browser $browser
     * @return void
     */
    public function handle(Browser $browser)
    {
        $browser->script(SendKeyUpEventScript::dispatchNow([
            // Send 'right arrow' key code
            '$keyCode' => 39
        ]));
        WaitForPostDialogAction::dispatchNow($browser);
        $browser->screenshot('open-next-post');
    }
}

<?php

namespace App\Jobs\Instagram\Actions;

use App\Jobs\Instagram\InstagramAction;
use App\Jobs\Instagram\Scripts\SendKeyUpEventScript;
use Exception;
use Laravel\Dusk\Browser;

class OpenNextPostAction extends InstagramAction
{
    protected Browser $browser;

    /**
     * Create a new job instance.
     *
     * @param Browser $browser
     * @param string $tag
     */
    public function __construct(Browser &$browser)
    {
        $this->browser = $browser;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle()
    {
        $this->browser->script(SendKeyUpEventScript::dispatchNow([
            // Send 'right arrow' key code
            '$keyCode' => 39
        ]));
        WaitForPostDialogAction::dispatchNow($this->browser);
        $this->browser->screenshot('open-next-post');
    }
}

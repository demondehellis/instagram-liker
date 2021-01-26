<?php

namespace App\Jobs\Instagram\Actions;

use App\Jobs\Instagram\InstagramAction;
use Exception;
use Laravel\Dusk\Browser;

class OpenFirstPostAction extends InstagramAction
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
        info('Open first post...');
        $this->browser->clickAtPoint(70, 70);
        WaitForPostDialogAction::dispatchNow($this->browser);
        $this->browser->screenshot('open-first-post');
    }
}

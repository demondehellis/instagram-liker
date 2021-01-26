<?php

namespace App\Jobs\Instagram\Actions;

use App\Jobs\Instagram\InstagramAction;
use Exception;
use Laravel\Dusk\Browser;

class WaitForPostDialogAction extends InstagramAction
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
        info('Wait for post dialog ' . $this->browser->driver->getCurrentURL());
        $this->browser->waitFor('[role="dialog"] article header', 30);
        $this->browser->screenshot('wait-for-post-dialog');
    }
}

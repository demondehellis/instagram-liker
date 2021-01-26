<?php

namespace App\Jobs\Instagram\Actions;

use App\Jobs\Instagram\InstagramAction;
use Exception;
use Laravel\Dusk\Browser;

class WaitSomeTimeAction extends InstagramAction
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
        $randomNumberOfMilliseconds = rand(1000, 10000);
        $this->browser->pause($randomNumberOfMilliseconds);
    }
}

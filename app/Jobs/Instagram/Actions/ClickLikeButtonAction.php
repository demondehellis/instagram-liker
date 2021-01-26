<?php

namespace App\Jobs\Instagram\Actions;

use App\Jobs\Instagram\InstagramAction;
use App\Jobs\Instagram\Scripts\ClickLikeButtonScript;
use Exception;
use Laravel\Dusk\Browser;

class ClickLikeButtonAction extends InstagramAction
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
        info('Like post: ' . $this->browser->driver->getCurrentURL());
        $this->browser->script(ClickLikeButtonScript::dispatchNow());
        $this->browser->screenshot('like-post');
    }
}

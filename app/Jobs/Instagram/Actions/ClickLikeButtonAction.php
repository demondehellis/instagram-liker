<?php

namespace App\Jobs\Instagram\Actions;

use App\Jobs\Instagram\InstagramAction;
use App\Jobs\Instagram\Scripts\ClickLikeButtonScript;
use Laravel\Dusk\Browser;

class ClickLikeButtonAction extends InstagramAction
{
    /**
     * Execute the job.
     *
     * @param Browser $browser
     * @return void
     */
    public function handle(Browser $browser)
    {
        info('Like post: ' . $browser->driver->getCurrentURL());
        $browser->script(ClickLikeButtonScript::dispatchNow());
        $browser->screenshot('like-post');
    }
}

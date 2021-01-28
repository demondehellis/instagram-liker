<?php

namespace App\Jobs\Instagram\Actions;

use App\Jobs\Instagram\InstagramAction;
use App\Jobs\Instagram\Scripts\ScrollToScript;
use Laravel\Dusk\Browser;

class ScrollToNewPostsAction extends InstagramAction
{
    /**
     * Execute the job.
     *
     * @param Browser $browser
     * @return void
     */
    public function handle(Browser $browser)
    {
        $script = ScrollToScript::dispatchNow([
            '$querySelector' => 'section main article > h2'
        ]);
        $browser->script($script);
        $browser->screenshot('scroll-to-new-posts');
    }
}

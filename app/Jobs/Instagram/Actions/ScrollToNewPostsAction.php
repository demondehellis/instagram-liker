<?php

namespace App\Jobs\Instagram\Actions;

use App\Jobs\Instagram\InstagramAction;
use App\Jobs\Instagram\Scripts\ScrollToScript;
use Exception;
use Laravel\Dusk\Browser;

class ScrollToNewPostsAction extends InstagramAction
{
    protected Browser $browser;
    protected string $tag;

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
        info('Scroll to new posts...');

        $script = ScrollToScript::dispatchNow([
            '$querySelector' => 'section main article > h2'
        ]);
        $this->browser->script($script);

        $this->browser->screenshot('scroll-to-new-posts');
    }
}

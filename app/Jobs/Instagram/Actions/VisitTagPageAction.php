<?php

namespace App\Jobs\Instagram\Actions;

use App\Jobs\Instagram\InstagramAction;
use Exception;
use Laravel\Dusk\Browser;

class VisitTagPageAction extends InstagramAction
{
    protected Browser $browser;
    protected string $tag;

    /**
     * Create a new job instance.
     *
     * @param Browser $browser
     * @param string $tag
     */
    public function __construct(Browser &$browser, string $tag)
    {
        $this->browser = $browser;
        $this->tag = $tag;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle()
    {
        $tagUrl = $this->getTagUrl($this->tag);

        info('Visit tag page: ' . $tagUrl);
        $this->browser->visit($tagUrl);
        $this->browser->screenshot('tag-page');
    }


    public function getTagUrl(string $tag): string
    {
        return "https://www.instagram.com/explore/tags/$tag/";
    }
}

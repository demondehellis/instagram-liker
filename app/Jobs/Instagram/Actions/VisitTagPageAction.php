<?php

namespace App\Jobs\Instagram\Actions;

use App\Jobs\Instagram\InstagramAction;
use Laravel\Dusk\Browser;

class VisitTagPageAction extends InstagramAction
{
    protected string $tag;
    
    /**
     * Create a new job instance.
     *
     * @param string $tag
     */
    public function __construct(string $tag)
    {
        $this->tag = $tag;
    }
    
    /**
     * Execute the job.
     *
     * @param Browser $browser
     * @return void
     */
    public function handle(Browser $browser)
    {
        $tagUrl = $this->getTagUrl($this->tag);

        info('Visit tag page: ' . $tagUrl);
        $browser->visit($tagUrl);
        $browser->screenshot('tag-page');
    }


    public function getTagUrl(string $tag): string
    {
        return "https://www.instagram.com/explore/tags/$tag/";
    }
}

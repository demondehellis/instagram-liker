<?php

namespace App\Jobs\Instagram;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Laravel\Dusk\Browser;

class VisitTagPageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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


    public function getTagUrl(string $tag)
    {
        return "https://www.instagram.com/explore/tags/$tag/";
    }
}

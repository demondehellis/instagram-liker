<?php

namespace App\Jobs\Instagram;

use App\Jobs\Instagram\Scripts\ScrollToScript;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Laravel\Dusk\Browser;

class ScrollToNewPostsJob implements ShouldQueue
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

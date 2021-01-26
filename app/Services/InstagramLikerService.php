<?php

namespace App\Services;

use App\Jobs\Browser\GetDriverBrowserJob;
use App\Jobs\Browser\SetUpBrowserJob;
use App\Jobs\Browser\TearDownBrowserJob;
use App\Jobs\Instagram\Actions\AuthorizeInstagramAction;
use App\Jobs\Instagram\Actions\ClickLikeButtonAction;
use App\Jobs\Instagram\Actions\ForEachPostAction;
use App\Jobs\Instagram\Actions\GetTagGeneratorAction;
use App\Jobs\Instagram\Actions\OpenFirstPostAction;
use App\Jobs\Instagram\Actions\ScrollToNewPostsAction;
use App\Jobs\Instagram\Actions\VisitTagPageAction;
use App\Jobs\Instagram\Actions\WaitSomeTimeAction;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Concerns\ProvidesBrowser;

class InstagramLikerService
{
    use ProvidesBrowser;

    public function likePostsByTag(string $tag, $limit = null)
    {
        $this->browse(function (Browser $browser) use ($tag, $limit) {

            AuthorizeInstagramAction::dispatchNow($browser);
            VisitTagPageAction::dispatchNow($browser, $tag);
            ScrollToNewPostsAction::dispatchNow($browser);
            OpenFirstPostAction::dispatchNow($browser);

            ForEachPostAction::dispatchNow($browser, function (Browser $browser){
                ClickLikeButtonAction::dispatchNow($browser);
                WaitSomeTimeAction::dispatchNow($browser);
            }, $limit);
        });
    }

    public function runLiker()
    {
        SetUpBrowserJob::dispatchNow();

        $tagGenerator = GetTagGeneratorAction::dispatchNow();
        foreach ($tagGenerator as $tag) {
            $this->likePostsByTag($tag, 3);
        }

        TearDownBrowserJob::dispatchNow();
    }

    public function getName()
    {
        return get_class($this);
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        return GetDriverBrowserJob::dispatchNow();
    }
}

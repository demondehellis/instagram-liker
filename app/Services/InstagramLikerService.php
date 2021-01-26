<?php

namespace App\Services;

use App\Jobs\Browser\GetDriverBrowserJob;
use App\Jobs\Browser\SetUpBrowserJob;
use App\Jobs\Browser\TearDownBrowserJob;
use App\Jobs\Instagram\AuthorizeInstagramJob;
use App\Jobs\Instagram\ScrollToNewPostsJob;
use App\Jobs\Instagram\VisitTagPageJob;
use Exception;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Support\Facades\Log;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Concerns\ProvidesBrowser;

class InstagramLikerService
{
    use ProvidesBrowser;

    public function getTags()
    {
        $tagsString = $_ENV['INSTAGRAM_TAGS'];
        $tags = explode(',', $tagsString);
        return $tags;
    }

    public function getTagGenerator()
    {
        $tags = $this->getTags();
        while (true){
            foreach ($tags as $tag){
                yield $tag;
            }
        }
    }

    public function getTagUrl(string $tag)
    {
        return "https://www.instagram.com/explore/tags/$tag/";
    }

    public function likePostsByTag(string $tag, $limit = null)
    {
        $this->browse(function (Browser $browser) use ($tag, $limit) {

            AuthorizeInstagramJob::dispatchNow($browser);
            VisitTagPageJob::dispatchNow($browser, $tag);
            ScrollToNewPostsJob::dispatchNow($browser);

            // todo: move to Jobs
            info('Click first post...');
            $browser->clickAtPoint(70,70);

            $likesNumber = 0;
            $isLikesLimitReached = false;
            while (!$isLikesLimitReached){

                info('Open new post ' . $browser->driver->getCurrentURL());
                try {
                    $browser->waitFor('[role="dialog"] article header', 30);
                } catch (\Exception $exception){
                    report($exception);
                    continue;
                }

                info('Like post...');
                $browser->script("
                let like = document.querySelector('svg[aria-label=\"Like\"]');
                var evt = new MouseEvent(\"click\", {
                    view: window,
                    bubbles: true,
                    cancelable: true,
                    clientX: 20,
                });
                like.dispatchEvent(evt);");

                info('Make screenshot...');
                $browser->screenshot('like');

                $isLikesLimitReached = (!is_null($limit) && ++$likesNumber >= $limit);
                if ($isLikesLimitReached == false){
                    info('Next post...');
                    $browser->script('window.dispatchEvent(new KeyboardEvent("keyup", { "keyCode": 39 }));');
                    $browser->pause(rand(1000,10000));
                }
            }
        });
    }

    public function runLiker()
    {
        SetUpBrowserJob::dispatchNow();

        $tagGenerator = $this->getTagGenerator();
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

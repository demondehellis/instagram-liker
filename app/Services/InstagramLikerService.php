<?php

namespace App\Services;

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

class InstagramLikerService
{
    public function likePostsByTag(string $tag, $limit = null)
    {
        AuthorizeInstagramAction::dispatchNow();
        
        VisitTagPageAction::dispatchNow($tag);
        ScrollToNewPostsAction::dispatchNow();
        OpenFirstPostAction::dispatchNow();
        
        ForEachPostAction::dispatchNow(function (){
            ClickLikeButtonAction::dispatchNow();
            WaitSomeTimeAction::dispatchNow();
        }, $limit);
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
}

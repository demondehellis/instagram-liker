<?php

namespace App\Jobs\Instagram\Flows;

use App\Jobs\Instagram\Actions\AuthorizeInstagramAction;
use App\Jobs\Instagram\Actions\ClickLikeButtonAction;
use App\Jobs\Instagram\Actions\ForEachPostAction;
use App\Jobs\Instagram\Actions\OpenFirstPostAction;
use App\Jobs\Instagram\Actions\ScrollToNewPostsAction;
use App\Jobs\Instagram\Actions\VisitTagPageAction;
use App\Jobs\Instagram\Actions\WaitForPostDialogAction;
use App\Jobs\Instagram\Actions\WaitSomeTimeAction;
use App\Jobs\Instagram\InstagramFlow;
use Exception;
use Illuminate\Support\Facades\Log;

class LikeTagsFlow extends InstagramFlow
{
    private ?int $likesPerTag;
    private iterable $tags;
    
    /**
     * LikeTagsFlow constructor.
     * @param iterable $tags
     * @param int|null $likesPerTag
     */
    public function __construct(iterable $tags, int $likesPerTag = null)
    {
        $this->tags = $tags;
        $this->likesPerTag = $likesPerTag;
    }
    
    public function handle()
    {
        AuthorizeInstagramAction::dispatchNow();
        foreach ($this->tags as $tag) {
            try {
                VisitTagPageAction::dispatchNow($tag);
                ScrollToNewPostsAction::dispatchNow();
                OpenFirstPostAction::dispatchNow();
            
                ForEachPostAction::dispatchNow(function () {
                    WaitForPostDialogAction::dispatchNow();
                    ClickLikeButtonAction::dispatchNow();
                    WaitSomeTimeAction::dispatchNow();
                }, $this->likesPerTag);
            } catch (Exception $exception) {
                Log::error($exception->getMessage());
                WaitSomeTimeAction::dispatchNow();
                continue;
            }
        }
    }
}
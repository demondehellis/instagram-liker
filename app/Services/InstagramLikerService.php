<?php

namespace App\Services;

use App\Jobs\Browser\SetUpBrowserJob;
use App\Jobs\Browser\TearDownBrowserJob;
use App\Jobs\Instagram\Actions\GetTagGeneratorAction;
use App\Jobs\Instagram\Actions\GetTagsAction;
use App\Jobs\Instagram\Flows\LikeTagsFlow;

class InstagramLikerService
{
    public function runLiker(bool $endless = false)
    {
        SetUpBrowserJob::dispatchNow();
        LikeTagsFlow::dispatchNow(
            $endless ? GetTagGeneratorAction::dispatchNow() : GetTagsAction::dispatchNow(),
            config('instagram.likes-per-tag')
        );
        TearDownBrowserJob::dispatchNow();
    }
}

<?php

namespace App\Services;

use App\Jobs\Browser\SetUpBrowserJob;
use App\Jobs\Browser\TearDownBrowserJob;
use App\Jobs\Instagram\Actions\GetTagGeneratorAction;
use App\Jobs\Instagram\Flows\LikeTagsFlow;

class InstagramLikerService
{
    public function runLiker()
    {
        SetUpBrowserJob::dispatchNow();
        LikeTagsFlow::dispatchNow(
            GetTagGeneratorAction::dispatchNow(),
            config('instagram.likes-per-tag')
        );
        TearDownBrowserJob::dispatchNow();
    }
}

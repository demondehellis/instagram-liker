<?php

namespace App\Jobs\Instagram\Actions;

use App\Jobs\Instagram\InstagramAction;

class GetTagsAction extends InstagramAction
{
    public function handle()
    {
        return explode(',', $_ENV['INSTAGRAM_TAGS']);
    }
}
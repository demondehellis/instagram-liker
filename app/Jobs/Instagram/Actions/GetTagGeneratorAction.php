<?php

namespace App\Jobs\Instagram\Actions;

use App\Jobs\Instagram\InstagramAction;
use Generator;

class GetTagGeneratorAction extends InstagramAction
{
    /**
     * Execute the job.
     *
     * @return Generator
     */
    public function handle(): Generator
    {
        $tags = GetTagsAction::dispatchNow();
        while (true) {
            foreach ($tags as $tag) {
                yield $tag;
            }
        }
    }
}

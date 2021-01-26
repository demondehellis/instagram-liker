<?php

namespace App\Jobs\Instagram\Actions;

use App\Jobs\Instagram\InstagramAction;
use Exception;

class GetTagGeneratorAction extends InstagramAction
{
    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle(): \Generator
    {
       return $this->getTagGenerator();
    }

    public function getTags()
    {
        return explode(',', $_ENV['INSTAGRAM_TAGS']);
    }
    
    public function getTagGenerator(): \Generator
    {
        $tags = $this->getTags();
        while (true) {
            foreach ($tags as $tag) {
                yield $tag;
            }
        }
    }
}

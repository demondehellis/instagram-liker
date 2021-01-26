<?php

namespace App\Jobs\Instagram;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetTagGeneratorJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    /**
     * Create a new job instance.
     *
     * @param string $tag
     */
    public function __construct()
    {
    }

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

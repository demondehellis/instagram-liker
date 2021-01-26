<?php

namespace App\Jobs\Instagram\Actions;

use App\Jobs\Instagram\InstagramAction;
use Closure;
use Exception;
use Laravel\Dusk\Browser;

class ForEachPostAction extends InstagramAction
{
    protected Browser $browser;
    protected Closure $callback;
    protected int $limit;
    protected int $iteration;
    
    /**
     * Create a new job instance.
     *
     * @param Browser $browser
     * @param Closure $callback
     * @param int $limit
     */
    public function __construct(Browser &$browser, Closure $callback, int $limit = 0)
    {
        $this->browser = $browser;
        $this->callback = $callback;
        $this->limit = $limit;
        $this->iteration = 0;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle()
    {
        while (!$this->isLimitReached()) {
        
            try {
                call_user_func($this->callback, $this->browser);
            } catch (\Exception $exception) {
                report($exception);
                continue;
            }
            
            $this->iteration++;
            if (!$this->isLimitReached()) {
                OpenNextPostAction::dispatchNow($this->browser);
            }
        }
    }
    
    protected function isLimitReached(): bool
    {
        return !empty($this->limit) && $this->iteration >= $this->limit;
    }
}

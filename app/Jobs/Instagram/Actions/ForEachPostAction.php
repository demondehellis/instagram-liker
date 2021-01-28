<?php

namespace App\Jobs\Instagram\Actions;

use App\Jobs\Instagram\InstagramAction;
use Closure;
use Laravel\Dusk\Browser;

class ForEachPostAction extends InstagramAction
{
    protected Closure $callback;
    protected int $limit;
    protected int $iteration;
    
    /**
     * Create a new job instance.
     *
     * @param Closure $callback
     * @param int $limit
     */
    public function __construct(Closure $callback, int $limit = 0)
    {
        $this->callback = $callback;
        $this->limit = $limit;
        $this->iteration = 0;
    }
    
    /**
     * Execute the job.
     *
     * @param Browser $browser
     * @return void
     */
    public function handle(Browser $browser)
    {
        while (!$this->isLimitReached()) {
        
            try {
                call_user_func($this->callback, $browser);
            } catch (\Exception $exception) {
                report($exception);
                continue;
            }
            
            $this->iteration++;
            if (!$this->isLimitReached()) {
                OpenNextPostAction::dispatchNow();
            }
        }
    }
    
    protected function isLimitReached(): bool
    {
        return !empty($this->limit) && $this->iteration >= $this->limit;
    }
}

<?php

namespace App\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class SyncJob
{
    use Dispatchable, SerializesModels;
    
    public function before()
    {
        if (config('logging.verbosity.before-job')) {
            info('Run ' . get_class($this));
        }
    }
    
    public function after()
    {
        if (config('logging.verbosity.after-job')){
            info('Finish ' . get_class($this));
        }
    }
    
    public function failed(Throwable $exception)
    {
        if (config('logging.verbosity.failed-job')){
            Log::error(
                'Failed ' . get_class($this) . ' with exception: ' . $exception->getMessage()
            );
        }
    }
}

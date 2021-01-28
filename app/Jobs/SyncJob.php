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
        info('Run ' . get_class($this));
    }
    
    public function after()
    {
        info('Finish ' . get_class($this));
    }
    
    public function failed(Throwable $exception)
    {
        Log::error('Failed ' . get_class($this) . ' with exception: ' . $exception->getMessage());
    }
}

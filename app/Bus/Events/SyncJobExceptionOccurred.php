<?php

namespace App\Bus\Events;

use App\Jobs\SyncJob;
use Throwable;

class SyncJobExceptionOccurred
{
    /**
     * The job instance.
     *
     * @var SyncJob
     */
    public SyncJob $job;

    /**
     * The exception instance.
     *
     * @var \Throwable
     */
    public Throwable $exception;
    
    /**
     * Create a new event instance.
     *
     * @param SyncJob $job
     * @param Throwable $exception
     */
    public function __construct(SyncJob $job, Throwable $exception)
    {
        $this->job = $job;
        $this->exception = $exception;
    }
}

<?php

namespace App\Bus\Events;

use App\Jobs\SyncJob;

class SyncJobProcessing
{
    /**
     * The job instance.
     *
     * @var SyncJob
     */
    public SyncJob $job;
    
    /**
     * Create a new event instance.
     *
     * @param SyncJob $job
     */
    public function __construct(SyncJob $job)
    {
        $this->job = $job;
    }
}

<?php

namespace App\Jobs\Instagram\Scripts;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class InstagramScript implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $params;

    /**
     * Create a new job instance.
     *
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $this->params = $params;
    }

    /**
     * @return string
     */
    public function buildScript(): string
    {
        return str_replace(
            array_keys($this->params),
            array_values($this->params),
            $this->getScriptTemplate()
        );
    }

    /**
     * Execute the job.
     *
     * @return string
     */
    public function handle(): string
    {
        return $this->buildScript();
    }

    /**
     * @return string
     */
    abstract public function getScriptTemplate(): string;
}

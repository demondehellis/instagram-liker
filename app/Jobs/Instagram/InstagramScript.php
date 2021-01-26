<?php

namespace App\Jobs\Instagram;

use App\Jobs\InstagramJob;

abstract class InstagramScript extends InstagramJob
{
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

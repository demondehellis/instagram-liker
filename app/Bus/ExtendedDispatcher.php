<?php

namespace App\Bus;

use App\Bus\Events\SyncJobExceptionOccurred;
use App\Bus\Events\SyncJobProcessed;
use App\Bus\Events\SyncJobProcessing;
use App\Jobs\SyncJob;
use Illuminate\Bus\Dispatcher as LaravelDispatcher;
use Illuminate\Contracts\Events\Dispatcher as EventsDispatcher;
use Throwable;

class ExtendedDispatcher extends LaravelDispatcher
{
    /**
     * @var EventsDispatcher
     */
    private $events;
    
    /**
     * ExtendedDispatcher constructor.
     * @param $app
     * @param LaravelDispatcher $dispatcher
     */
    public function __construct($app, LaravelDispatcher $dispatcher)
    {
        $this->events = app(EventsDispatcher::class);
        parent::__construct($app, $dispatcher->queueResolver);
    }
    
    /**
     * Overrides dispatchNow method to rise sync job events
     *
     * @param mixed $command
     * @param null $handler
     * @return mixed
     * @throws Throwable
     */
    public function dispatchNow($command, $handler = null)
    {
        $result = null;
        
        try {
            $this->raiseSyncJobProcessingEvent($command);
            $result = $this->run($command, $handler);
            $this->raiseSyncJobProcessedEvent($command);
            
        } catch (Throwable $e) {
            $this->raiseSyncJobExceptionOccurredEvent($command, $e);
            throw $e;
        }
        
        return $result;
    }
    
    /**
     * Dispatch a command to its appropriate handler in the current process without using the synchronous queue.
     *
     * @param mixed $command
     * @param mixed $handler
     * @return mixed
     */
    public function run($command, $handler = null)
    {
        if ($handler || $handler = $this->getCommandHandler($command)) {
            $callback = function ($command) use ($handler) {
                $method = method_exists($handler, 'handle') ? 'handle' : '__invoke';
            
                return $handler->{$method}($command);
            };
        } else {
            $callback = function ($command) {
                $method = method_exists($command, 'handle') ? 'handle' : '__invoke';
            
                return $this->container->call([$command, $method]);
            };
        }
    
        return $this->pipeline->send($command)->through($this->pipes)->then($callback);
    }
    
    /**
     * Raise the sync job processing event.
     *
     * @param SyncJob $job
     * @return void
     */
    protected function raiseSyncJobProcessingEvent(SyncJob $job)
    {
        $this->events->dispatch(new SyncJobProcessing($job));
    }
    
    /**
     * Raise the sync job processed event.
     *
     * @param SyncJob $job
     * @return void
     */
    protected function raiseSyncJobProcessedEvent(SyncJob $job)
    {
        $this->events->dispatch(new SyncJobProcessed($job));
    }
    
    /**
     * Raise the sync job exception occurred event.
     *
     * @param SyncJob $job
     * @param Throwable $e
     * @return void
     */
    protected function raiseSyncJobExceptionOccurredEvent(SyncJob $job, Throwable $e)
    {
        $this->events->dispatch(new SyncJobExceptionOccurred($job, $e));
    }
    
}
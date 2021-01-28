<?php

namespace App\Bus\Observers;

use App\Bus\Events\SyncJobExceptionOccurred;
use App\Bus\Events\SyncJobProcessed;
use App\Bus\Events\SyncJobProcessing;

class SyncJobObserver
{
    public static function boot()
    {
        self::addBeforeExecutionEventListened();
        self::addAfterExecutionEventListener();
        self::addFailedExecutionEventListener();
    }
    
    public static function addBeforeExecutionEventListened(): void
    {
        app('events')->listen(SyncJobProcessing::class, function (SyncJobProcessing $event) {
            if (method_exists($event->job, 'before')) {
                app()->call([$event->job, 'before']);
            }
        });
    }
    
    public static function addAfterExecutionEventListener(): void
    {
        app('events')->listen(SyncJobProcessed::class, function (SyncJobProcessed $event) {
            if (method_exists($event->job, 'after')) {
                app()->call([$event->job, 'after']);
            }
        });
    }
    
    public static function addFailedExecutionEventListener(): void
    {
        app('events')->listen(SyncJobExceptionOccurred::class, function (SyncJobExceptionOccurred $event) {
            if (method_exists($event->job, 'failed')) {
                app()->call([$event->job, 'failed'], [
                    'exception' => $event->exception
                ]);
            }
        });
    }
}
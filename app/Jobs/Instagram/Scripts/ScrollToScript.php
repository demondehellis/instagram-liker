<?php

namespace App\Jobs\Instagram\Scripts;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ScrollToScript extends InstagramScript
{
    public function getScriptTemplate(): string
    {
        // return 'window.scrollBy(0,1000)';s
        return '
        let element = document.querySelector("$querySelector");
        if (element){
           element.scrollIntoView({block: "start"});
        }';
    }
}

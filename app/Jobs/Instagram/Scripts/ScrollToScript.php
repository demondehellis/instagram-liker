<?php

namespace App\Jobs\Instagram\Scripts;

use App\Jobs\Instagram\InstagramScript;

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

<?php

namespace App\Jobs\Instagram\Scripts;

use App\Jobs\Instagram\InstagramScript;

class SendKeyUpEventScript extends InstagramScript
{
    public function getScriptTemplate(): string
    {
        return 'window.dispatchEvent(new KeyboardEvent("keyup", { "keyCode": $keyCode }));';
    }
}

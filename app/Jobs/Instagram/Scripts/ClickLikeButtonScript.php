<?php

namespace App\Jobs\Instagram\Scripts;

use App\Jobs\Instagram\InstagramScript;

class ClickLikeButtonScript extends InstagramScript
{
    public function getScriptTemplate(): string
    {
        return "
                let like = document.querySelector('svg[aria-label=\"Like\"]');
                var evt = new MouseEvent('click', {
                    view: window,
                    bubbles: true,
                    cancelable: true,
                    clientX: 20,
                });
                if (!!like){
                    like.dispatchEvent(evt);
                }";
    }
}

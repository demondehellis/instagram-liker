<?php

namespace App\Jobs\Instagram\Actions;

use App\Jobs\Instagram\InstagramAction;
use Exception;
use Laravel\Dusk\Browser;

class AuthorizeInstagramAction extends InstagramAction
{
    /**
     * Execute the job.
     *
     * @param Browser $browser
     * @return void
     * @throws Exception
     */
    public function handle(Browser $browser)
    {
        $sessionId = env('INSTAGRAM_SESSION_ID');
        if (empty($sessionId)){
            throw new Exception('Environment variable INSTAGRAM_SESSION_ID is not set');
        }
    
        $browser->visit('https://www.instagram.com/');
        AcceptCookiePolicyAction::dispatchNow();
    
        $browser->plainCookie('sessionid',$sessionId);
        VerifyAuthAction::dispatchNow();
    }
}

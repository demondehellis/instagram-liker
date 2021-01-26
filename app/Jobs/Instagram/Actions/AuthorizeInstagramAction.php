<?php

namespace App\Jobs\Instagram\Actions;

use App\Jobs\Instagram\InstagramAction;
use Exception;
use Laravel\Dusk\Browser;

class AuthorizeInstagramAction extends InstagramAction
{
    protected $browser;

    /**
     * Create a new job instance.
     *
     * @param Browser $browser
     */
    public function __construct(Browser &$browser)
    {
        $this->browser = $browser;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle()
    {
        info('Authorize Instagram');
        $sessionId = env('INSTAGRAM_SESSION_ID');
        if (empty($sessionId)){
            throw new Exception('Environment variable INSTAGRAM_SESSION_ID is not set');
        }

        $this->browser
            ->visit('https://www.instagram.com/')
            ->plainCookie('sessionid',$sessionId);
        $this->browser->screenshot('auth');
    }
}

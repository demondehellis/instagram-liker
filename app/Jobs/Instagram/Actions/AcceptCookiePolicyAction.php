<?php

namespace App\Jobs\Instagram\Actions;

use App\Jobs\Instagram\InstagramAction;
use Exception;
use Laravel\Dusk\Browser;
use Throwable;

class AcceptCookiePolicyAction extends InstagramAction
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
        // Accept cookie dialog appears depending on IP location ( GDPR policy for Europe ),
        // so we just skip it if it's not visible.
        try {
            $browser->waitForTextIn('[role="dialog"] button', 'Accept');
            $browser->press('Accept');
        } catch (Throwable $exception) {
            info($exception->getMessage() . ' -> skip cookie accept dialog');
        }
    }
}

<?php

namespace App\Jobs\Browser;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Laravel\Dusk\Concerns\ProvidesBrowser;

class GetDriverBrowserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, ProvidesBrowser;

    public static $driver = null;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return RemoteWebDriver
     */
    public function handle()
    {
        return $this->driver();
    }

    protected function driver(): ?RemoteWebDriver
    {
        return self::$driver ?? self::initDriver();
    }

    public static function initDriver(): ?RemoteWebDriver
    {
        info('Init driver');

        $seleniumHost = $_ENV['SELENIUM_HOST'];
        $options = (new ChromeOptions)->addArguments([
            '--disable-gpu',
            '--headless',
            '--whitelisted-ips=""',
            '--window-size=420,500',
        ]);

        $connected = false;
        while (!$connected){
            try {
                Log::info('Connecting to ' . $seleniumHost);
                self::$driver = RemoteWebDriver::create(
                    $seleniumHost,
                    DesiredCapabilities::chrome()->setCapability(
                        ChromeOptions::CAPABILITY, $options
                    )
                );
            } catch (\Exception $exception){
                Log::error($exception->getMessage());
                sleep(1);
                continue;
            }
            $connected = true;
        }

        return self::$driver;
    }
}

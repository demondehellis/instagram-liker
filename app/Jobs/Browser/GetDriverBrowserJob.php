<?php

namespace App\Jobs\Browser;

use App\Jobs\BrowserJob;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Support\Facades\Log;

class GetDriverBrowserJob extends BrowserJob
{
    public static RemoteWebDriver $driver;

    /**
     * Execute the job.
     *
     * @return RemoteWebDriver
     */
    public function handle(): ?RemoteWebDriver
    {
        return $this->driver();
    }
    
    /**
     * @return RemoteWebDriver
     */
    protected function driver(): ?RemoteWebDriver
    {
        return self::$driver ?? self::initDriver();
    }
    
    /**
     * @return RemoteWebDriver
     */
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

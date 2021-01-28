<?php

namespace App\Browser;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Support\Facades\Log;

class Driver
{
    public static function init(): ?RemoteWebDriver
    {
        $driver = null;
        
        $seleniumHost = $_ENV['SELENIUM_HOST'];
        $options = (new ChromeOptions)->addArguments([
            '--disable-gpu',
            '--headless',
            '--whitelisted-ips=""',
            '--window-size=420,500',
        ]);
        
        $connected = false;
        while (!$connected) {
            try {
                Log::info('Connecting to ' . $seleniumHost);
                $driver = RemoteWebDriver::create(
                    $seleniumHost,
                    DesiredCapabilities::chrome()->setCapability(
                        ChromeOptions::CAPABILITY, $options
                    )
                );
            } catch (\Exception $exception) {
                Log::error($exception->getMessage());
                sleep(1);
                continue;
            }
            $connected = true;
        }
        
        return $driver;
    }
}
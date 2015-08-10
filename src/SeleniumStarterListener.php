<?php

namespace Fonsecas72\SeleniumStarterExtension;

use Behat\Testwork\EventDispatcher\Event\BeforeExerciseCompleted;
use BeubiQA\Application\Selenium\Options\SeleniumStartOptions;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ExecutableFinder;
use BeubiQA\Application\Lib\ResponseWaitter;
use GuzzleHttp\Client;
use BeubiQA\Application\Selenium\SeleniumStarter;
use BeubiQA\Application\Selenium\SeleniumStopper;
use BeubiQA\Application\Selenium\SeleniumDownloader;
use BeubiQA\Application\Lib\LogWatcher;
use BeubiQA\Application\Selenium\SeleniumHandler;
use BeubiQA\Application\Selenium\Options\SeleniumStopOptions;
use BeubiQA\Application\Selenium\Options\SeleniumDownloaderOptions;

class SeleniumStarterListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            BeforeExerciseCompleted::BEFORE => array('startSelenium', 10),
        );
    }

    public function startSelenium(BeforeExerciseCompleted $event)
    {
        $process = new Process('');
        $exeFinder = new ExecutableFinder();
        $httpClient = new Client();
        $waiter = new ResponseWaitter($httpClient);
        $seleniumStarterOptions = new SeleniumStartOptions();
        $seleniumStarterOptions->enabledXvfb();
        $seleniumStarter = new SeleniumStarter($seleniumStarterOptions, $process, $waiter, $exeFinder);
        $seleniumStopperOptions = new SeleniumStopOptions();
        $seleniumStopper = new SeleniumStopper($seleniumStopperOptions, $waiter, $httpClient);
        $seleniumDownloaderOptions = new SeleniumDownloaderOptions();
        $seleniumDownloader = new SeleniumDownloader($seleniumDownloaderOptions, $httpClient);
        $seleniumLogWatcher = new LogWatcher();
        $seleniumHandler = new SeleniumHandler(
            $seleniumStarter,
            $seleniumStopper,
            $seleniumDownloader,
            $seleniumLogWatcher
        );
        $seleniumHandler->start();
    }
}

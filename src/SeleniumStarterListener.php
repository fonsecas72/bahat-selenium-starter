<?php

namespace Fonsecas72\SeleniumStarterExtension;

use Behat\Testwork\EventDispatcher\Event\BeforeExerciseCompleted;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use BeubiQA\Application\Selenium\SeleniumHandler;

class SeleniumStarterListener implements EventSubscriberInterface
{
    /**  @var SeleniumHandler */
    private $seleniumHandler;

    public function __construct(SeleniumHandler $seleniumHandler)
    {
        $this->seleniumHandler = $seleniumHandler;
    }
    public static function getSubscribedEvents()
    {
        return array(
            BeforeExerciseCompleted::BEFORE => array('startSelenium', 10)
        );
    }

    public function startSelenium($event)
    {
        $this->seleniumHandler->start();
    }
}

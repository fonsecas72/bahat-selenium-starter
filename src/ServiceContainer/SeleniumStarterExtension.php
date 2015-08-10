<?php

namespace Fonsecas72\SeleniumStarterExtension\ServiceContainer;

use Behat\Testwork\EventDispatcher\ServiceContainer\EventDispatcherExtension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Behat\Testwork\ServiceContainer\Extension;

class SeleniumStarterExtension implements Extension
{
    public function initialize(ExtensionManager $extensionManager){}
    
    public function load(ContainerBuilder $container, array $config)
    {
        $definition = new Definition('Fonsecas72\SeleniumStarterExtension\SeleniumStarterListener');
        $definition->addTag(EventDispatcherExtension::SUBSCRIBER_TAG, array('priority' => 0));
        $container->setDefinition('behat.selenium-starter', $definition);
    }

    public function getConfigKey()
    {
        return 'selenium-starter';
    }

    public function configure(ArrayNodeDefinition $builder){}
    public function process(ContainerBuilder $container){}
}

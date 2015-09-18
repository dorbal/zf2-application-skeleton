<?php

namespace Application;

use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\Mvc\MvcEvent;

use ZendDiagnostics\Check\DirReadable;
use ZendDiagnostics\Check\DirWritable;
use ZendDiagnostics\Check\ExtensionLoaded;
use ZendDiagnostics\Check\PhpVersion;
use ZendDiagnostics\Check\SecurityAdvisory;

class Module
{
    public function getConsoleUsage(Console $console)
    {
        return array(
            'deploy' => 'Application deployment',
            'maintenance' => 'Application maintenance',
            'password <password>' => 'Encode password',
        );
    }

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        if (function_exists('fastcgi_finish_request')) {
            $eventManager->attach(MvcEvent::EVENT_FINISH, 'fastcgi_finish_request', -20000);
        }

        $sharedEventManager = $eventManager->getSharedManager();
        $sharedEventManager->attach(
            'Application',
            'DeployEvent',
            'Application\Listener\DeployListener::flushCache',
            -10000
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getDiagnostics()
    {
        $paths = [
            'data/cache', 'data/config-cache', 'data/logs', 'data/tmp'
        ];

        return [
            new PhpVersion('5.5'),
            new DirReadable($paths),
            new DirWritable($paths),
            new ExtensionLoaded(['mbstring', 'pdo_mysql']),
            new SecurityAdvisory(),
        ];
    }
}

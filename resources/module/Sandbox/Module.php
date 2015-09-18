<?php
namespace Sandbox;

use ZendDiagnostics\Check\ExtensionLoaded;

class Module
{
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
        return [
            new ExtensionLoaded(['xdebug']),
        ];
    }
}

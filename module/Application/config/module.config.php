<?php

return array(
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
            'Application\Cache' => 'Zend\Cache\Service\StorageCacheFactory',
        ),
        'invokables' => array(
            'Application\Password' => 'Zend\Crypt\Password\BcryptSha',
        ),
        'shared' => array(
            'Application\Cache' => false,
        ),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'application-deploy' => array(
                    'options' => array(
                        'route' => 'deploy',
                        'defaults' => array(
                            'controller' => 'Application\Controller\Console',
                            'action' => 'deploy'
                        )
                    )
                ),
                'application-maintenance' => array(
                    'options' => array(
                        'route' => 'maintenance',
                        'defaults' => array(
                            'controller' => 'Application\Controller\Console',
                            'action' => 'maintenance'
                        )
                    )
                ),
                'application-password' => array(
                    'options' => array(
                        'route' => 'password <password>',
                        'defaults' => array(
                            'controller' => 'Application\Controller\Console',
                            'action' => 'password'
                        )
                    )
                ),
            )
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Console' => 'Application\Controller\ConsoleController',
        ),
    ),
);

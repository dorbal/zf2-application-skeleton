<?php
return array(
    'router' => array(
        'routes' => array(
            'sandbox' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/sandbox',
                    'defaults' => array(
                        'controller' => 'Sandbox\Controller\Sandbox',
                        'action'     => 'index',
                    ),
                ),
            ),
         ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Sandbox\Controller\Sandbox' => 'Sandbox\Controller\SandboxController'
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__.'/../view'
        )
    ),
);
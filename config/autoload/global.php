<?php

$dbConfig = [];
if (defined('PDO::MYSQL_ATTR_INIT_COMMAND')) {
    $dbConfig = array(
        'driver'            => 'Pdo_Mysql',
        'driver_options'    => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
        ),
    );
}

return array(
    'db' => $dbConfig,
    'cache' => array(
        'adapter' => array(
            'name' => 'filesystem',
            'options' => array(
                'ttl' => 3600,
                'cache_dir' => 'data/cache',
            ),
        ),
        'plugins' => array(
            'exception_handler' => array(
                'throw_exceptions' => false,
            ),
            'serializer',
            'ignore_user_abort',
            'clear_expired_by_factor' => array(
                'optimizing_factor' => 100
            )
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason'  => false,
        'display_exceptions'        => false,
        'not_found_template'        => 'error/404',
        'exception_template'        => 'error/index',
        'template_map'              => require __DIR__.'/template_map.php',
        'template_path_stack'       => array(
            'view',
        ),
    ),
);

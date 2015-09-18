<?php

use Zend\Mvc\Application;
use Zend\Stdlib\ArrayUtils;

chdir(dirname(__DIR__));

require 'vendor/autoload.php';

$appConfig = require 'config/application.config.php';

if (file_exists('config/additional.config.local.php')) {
    $appConfig = ArrayUtils::merge($appConfig, require 'config/additional.config.local.php');
}

Application::init($appConfig)->run();

<?php

$config = file_get_contents(__DIR__.'/nginx.conf.dist');

$baseDir = realpath(__DIR__.'/../../../');

echo str_replace('{BASE_DIR}', $baseDir, $config);

# author: Dormány Balázs József (dormany@dormany.hu)

PHP		= /usr/bin/php
YUI_COMPRESSOR 	= /usr/bin/yui-compressor

install: composer.phar vendor config/config.ini config/webserver/nginx.conf

uninstall: clear-config
	rm composer.lock -f;
	rm vendor -rf;
	rm composer.phar -f;

enable-diag: clear-config
	cp resources/config/diagnostics.config.php.dist config/additional.config.local.php;
	cp resources/config/autoload/zftool.local.php.dist config/autoload/zftool.local.php;

disable-diag: clear-config

dev: clear-config module/Sandbox
	$(PHP) composer.phar self-update;
	$(PHP) composer.phar update;
	cp resources/config/development.config.php.dist config/additional.config.local.php;
	cp resources/config/autoload/zftool.local.php.dist config/autoload/zftool.local.php;
	cp resources/config/autoload/development.local.php.dist config/autoload/development.local.php;
	cp vendor/zendframework/zend-developer-tools/config/zenddevelopertools.local.php.dist config/autoload/zenddevelopertools.local.php

test:
	$(PHP) vendor/bin/phpunit --configuration module/Application/tests/phpunit.xml --verbose --coverage-html data/tmp/coverage/application --coverage-text;

prod: clear-config
	rm module/Sandbox -rf;
	$(PHP) composer.phar self-update;
	$(PHP) composer.phar update --optimize-autoloader --no-dev;
	make clear-config;
	

deploy: 
	sudo rm data/config-cache/*.php -f;	
	make template-map;
	sudo $(PHP) public/index.php deploy;
	sudo rm data/config-cache/*.php -f;
	sudo rm data/tmp/* -rf;

template-map:
	$(PHP) vendor/bin/templatemap_generator.php --overwrite --output config/autoload/template_map.php


composer.phar:
	$(PHP) -r "eval('?>'.file_get_contents('https://getcomposer.org/installer'));";
vendor:
	$(PHP) composer.phar install --optimize-autoloader --no-dev;

config/config.ini: resources/config/config.ini.dist
	cp -i resources/config/config.ini.dist config/config.ini;

config/webserver/nginx.conf: resources/config/webserver/nginx.conf.dist
	$(PHP) resources/config/webserver/gen-nginx-conf.php > data/tmp/nginx.conf;
	cp -i data/tmp/nginx.conf config/webserver/nginx.conf;
	rm data/tmp/nginx.conf -f;

module/Sandbox:
	cp -r resources/module/Sandbox module/Sandbox;

clear-config:
	rm config/*.local.* -f;
	rm config/local.* -f;
	rm config/autoload/*.local.* -f;
	rm config/autoload/local.* -f;
	sudo rm data/config-cache/*.php -f;	

<?php

$loader = new \Phalcon\Loader();

$loader->registerNamespaces([
    'Games\Module\Api\Controller' => APPLICATION_PATH . '/modules/api/controllers/',
    'Games\Module\Api\Plugin' => APPLICATION_PATH . '/modules/api/plugins/',
]);

$loader->register();
<?php

$loader = new \Phalcon\Loader();

$loader->registerNamespaces([
    'Games\Module\Api\Controller' => APPLICATION_PATH . '/modules/api/controllers/',
]);

$loader->register();
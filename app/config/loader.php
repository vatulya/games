<?php

$loader = new \Phalcon\Loader();

$loader->registerNamespaces([
    'Games\Library' => APPLICATION_PATH . '/libraries',
    'Games\Model' => APPLICATION_PATH . '/models',
    'Games\Plugin' => APPLICATION_PATH . '/plugins',
    'Games\Service' => APPLICATION_PATH . '/services',
]);

$loader->register();


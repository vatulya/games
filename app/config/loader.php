<?php

use Phalcon\Loader as PhalconLoader;

$loader = new PhalconLoader();

$loader->registerNamespaces([
    'Games\Library' => APPLICATION_PATH . '/libraries',
    'Games\Collection' => APPLICATION_PATH . '/collections',
    'Games\Model' => APPLICATION_PATH . '/models',
    'Games\Plugin' => APPLICATION_PATH . '/plugins',
    'Games\Service' => APPLICATION_PATH . '/services',
]);

$loader->register();


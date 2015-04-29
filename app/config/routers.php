<?php

use Phalcon\Mvc\Router;

$di->set('router', function () use ($config) {

    $router = new Router();

    $router->setDefaultModule('frontend');
    $router->setDefaultController('index');
    $router->setDefaultAction('index');

    $router->add('/:module/:controller/:action', [
        'module' => 1,
        'controller' => 2,
        'action' => 3,
    ]);

    $router->add('/:controller/:action', [
        'namespace' => 'Module\Frontend\Controller',
        'controller' => 1,
        'action' => 2,
    ]);

    return $router;
});
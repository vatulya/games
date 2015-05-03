<?php

use Phalcon\Mvc\Router as Router;
use Phalcon\Mvc\Router\Group as RouterGroup;

$di = \Phalcon\Di::getDefault();

$di->set('router', function () use ($di) {

    /** @var \Phalcon\Config $config */
    $config = $di->get('config');

    $router = new Router();
    $router->removeExtraSlashes(true);
    $router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI); // use $_SERVER['REQUEST_URI'] (default)

    $addSubRoutes = function ($router) {
        /** @var Router $router */
        $router->add('/');
        $router->add('/:controller', ['controller' => 1]);
        $router->add('/:controller/:action', ['controller' => 1, 'action' => 2]);
        return true;
    };

    // Admin module
    $adminGroup = new RouterGroup([
        'module' => 'admin',
    ]);
    $adminGroup->setHostname($config['moduleUrlBase']['admin']);
    $addSubRoutes($adminGroup);
    $router->mount($adminGroup);

    // Api module
    $apiGroup = new RouterGroup([
        'module' => 'api',
        'controller' => 'index',
        'action' => 'index',
    ]);
    $apiGroup->setHostname($config['moduleUrlBase']['api']);
    $addSubRoutes($apiGroup);
    $router->mount($apiGroup);

    // Backend module
    $backendGroup = new RouterGroup([
        'module' => 'backend',
        'controller' => 'index',
        'action' => 'index',
    ]);
    $backendGroup->setHostname($config['moduleUrlBase']['backend']);
    $addSubRoutes($backendGroup);
    $router->mount($backendGroup);

    // Frontend module
    $frontendGroup = new RouterGroup([
        'module' => 'frontend',
        'controller' => 'index',
        'action' => 'index',
    ]);
    $frontendGroup->setHostname($config['moduleUrlBase']['frontend']);
    $addSubRoutes($frontendGroup);
    $router->mount($frontendGroup);

    return $router;
});
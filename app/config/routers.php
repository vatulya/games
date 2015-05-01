<?php

use Phalcon\Mvc\Router;
use Phalcon\Mvc\Router\Group as RouterGroup;

$di->set('router', function () use ($config) {

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

    // Frontend module
    $frontendGroup = new RouterGroup([
        'module' => 'frontend',
        'controller' => 'index',
        'action' => 'index',
    ]);
    $frontendGroup->setHostname('games.local');
    $addSubRoutes($frontendGroup);
    $router->mount($frontendGroup);

    // Backend module
    $backendGroup = new RouterGroup([
        'module' => 'backend',
        'controller' => 'index',
        'action' => 'index',
    ]);
    $backendGroup->setHostname('backend.games.local');
    $addSubRoutes($backendGroup);
    $router->mount($backendGroup);

    // Api module
    $apiGroup = new RouterGroup([
        'module' => 'api',
        'controller' => 'index',
        'action' => 'index',
    ]);
    $apiGroup->setHostname('api.games.local');
    $addSubRoutes($apiGroup);
    $router->mount($apiGroup);

    // Admin module
    $adminGroup = new RouterGroup([
        'module' => 'admin',
    ]);
    $adminGroup->setHostname('admin.games.local');
    $addSubRoutes($adminGroup);
    $router->mount($adminGroup);

    return $router;
});
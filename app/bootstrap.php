<?php

use Phalcon\DI\FactoryDefault;

defined('APPLICATION_PATH') || define('APPLICATION_PATH', __DIR__);

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * Read the Global configuration, Loader and Services
 */
$config = include APPLICATION_PATH . '/config/config.php';

include APPLICATION_PATH . '/config/loader.php';
include APPLICATION_PATH . '/config/routers.php';
include APPLICATION_PATH . '/config/services.php';

$application = new \Phalcon\Mvc\Application($di);

// Register the installed modules
$application->registerModules([
    'admin' => [
        'className' => 'Module\Admin\Module',
        'path' => APPLICATION_PATH . '/modules/admin/Module.php',
    ],
    'api' => [
        'className' => 'Module\Api\Module',
        'path' => APPLICATION_PATH . '/modules/api/Module.php',
    ],
    'frontend' => [
        'className' => 'Module\Frontend\Module',
        'path' => APPLICATION_PATH . '/modules/frontend/Module.php',
    ],
    'backend' => [
        'className' => 'Module\Backend\Module',
        'path' => APPLICATION_PATH . '/modules/backend/Module.php',
    ],
]);

return $application;
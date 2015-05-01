<?php

use Phalcon\DI\FactoryDefault;

defined('APPLICATION_PATH') || define('APPLICATION_PATH', __DIR__);

$di = new FactoryDefault();

$config = include APPLICATION_PATH . '/config/config.php';

include APPLICATION_PATH . '/config/loader.php';
include APPLICATION_PATH . '/config/routers.php';
include APPLICATION_PATH . '/config/services.php';
include APPLICATION_PATH . '/config/events.php';

$application = new \Phalcon\Mvc\Application($di);

// Register the installed modules
$application->registerModules([
    'admin' => [
        'className' => 'Games\Module\Admin\Module',
        'path' => APPLICATION_PATH . '/modules/admin/Module.php',
    ],
    'api' => [
        'className' => 'Games\Module\Api\Module',
        'path' => APPLICATION_PATH . '/modules/api/Module.php',
    ],
    'frontend' => [
        'className' => 'Games\Module\Frontend\Module',
        'path' => APPLICATION_PATH . '/modules/frontend/Module.php',
    ],
    'backend' => [
        'className' => 'Games\Module\Backend\Module',
        'path' => APPLICATION_PATH . '/modules/backend/Module.php',
    ],
]);

return $application;
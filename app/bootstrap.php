<?php

use Phalcon\Di as Di;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Application as PhalconApplication;
use Games\Library\File\Loader as FileLoader;

defined('APPLICATION_PATH') || define('APPLICATION_PATH', __DIR__);
defined('LOGS_PATH') || define('LOGS_PATH', APPLICATION_PATH . '/../logs');

require_once APPLICATION_PATH . '/libraries/File/Loader.php'; // Access to FileLoader class

$di = new FactoryDefault();
$di->setShared('config', new \Phalcon\Config());

Di::reset();
Di::setDefault($di);

FileLoader::includeFile(APPLICATION_PATH . '/config/loader.php');
FileLoader::includeConfig(APPLICATION_PATH . '/config/config.php');
FileLoader::includeFile(APPLICATION_PATH . '/config/routers.php');
FileLoader::includeFile(APPLICATION_PATH . '/config/services.php');
FileLoader::includeFile(APPLICATION_PATH . '/config/events.php');

$application = new PhalconApplication($di);

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
<?php

use Phalcon\Di as Di;
use Phalcon\DI\FactoryDefault as FactoryDefault;
use Games\Library\File\Loader as FileLoader;

ini_set('display_errors',1);
error_reporting(E_ALL);

$env = isset($_SERVER['APPLICATION_ENV']) ? $_SERVER['APPLICATION_ENV'] : 'production';
define('APPLICATION_ENV', $env);

define('TEST_PATH', __DIR__);
defined('APPLICATION_PATH') || define('APPLICATION_PATH', __DIR__ . '/../../app');
defined('LOGS_PATH') || define('LOGS_PATH', APPLICATION_PATH . '/../logs-tests');

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

require_once APPLICATION_PATH . '/modules/api/Module.php';
$module = new \Games\Module\Api\Module();
$module->registerAutoloaders($di);
$module->registerServices($di);

$loader = new \Phalcon\Loader();
$loader->registerNamespaces([
    'Test\Games' => TEST_PATH,
    'Test\Games\Module\Api\Controller' => TEST_PATH . '/modules/api/controllers',
]);
$loader->register();

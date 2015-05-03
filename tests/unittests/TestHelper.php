<?php
use Phalcon\DI;
use Phalcon\DI\FactoryDefault;

ini_set('display_errors',1);
error_reporting(E_ALL);

define('TEST_PATH', __DIR__);
defined('APPLICATION_PATH') || define('APPLICATION_PATH', __DIR__ . '/../../app');

$di = new FactoryDefault();
DI::reset();

$config = include APPLICATION_PATH . '/config/config.php';

include APPLICATION_PATH . '/config/loader.php';
include APPLICATION_PATH . '/config/routers.php';
include APPLICATION_PATH . '/config/services.php';
include APPLICATION_PATH . '/config/events.php';

$loader = new \Phalcon\Loader();
$loader->registerNamespaces([
    'Test\Games' => TEST_PATH   ,
]);
$loader->register();

DI::setDefault($di);

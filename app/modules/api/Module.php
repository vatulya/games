<?php

namespace Games\Module\Api;

use Phalcon\Mvc\ModuleDefinitionInterface;
use Games\Library\File\Loader as FileLoader;

defined('MODULE_PATH') || define('MODULE_PATH', __DIR__);

class Module implements ModuleDefinitionInterface
{

    /**
     * Registers an autoloader related to the module
     *
     * @param \Phalcon\DiInterface $dependencyInjector
     */
    public function registerAutoloaders(\Phalcon\DiInterface $dependencyInjector = null) {
        FileLoader::includeFile(__DIR__ . '/config/loader.php');

    }

    /**
     * Registers an autoloader related to the module
     *
     * @param \Phalcon\DiInterface $dependencyInjector
     */
    public function registerServices(\Phalcon\DiInterface $dependencyInjector) {
        FileLoader::includeConfig(__DIR__ . '/config/config.php');
        FileLoader::includeFile(__DIR__ . '/config/routers.php', true);
        FileLoader::includeFile(__DIR__ . '/config/services.php', true);
        FileLoader::includeFile(__DIR__ . '/config/events.php', true);
    }

}

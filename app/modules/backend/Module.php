<?php

namespace Games\Module\Backend;

use Phalcon\Config;
use Phalcon\Di;
use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View;

defined('MODULE_PATH') || define('MODULE_PATH', __DIR__);

class Module implements ModuleDefinitionInterface
{

    /**
     * Registers an autoloader related to the module
     *
     * @param \Phalcon\DiInterface $dependencyInjector
     */
    public function registerAutoloaders(\Phalcon\DiInterface $dependencyInjector = null) {
        $loader = new Loader();

        $loader->registerNamespaces([
            'Games\Module\Backend\Controller' => '../app/modules/backend/controllers/',
        ]);

        $loader->register();
    }

    /**
     * Registers an autoloader related to the module
     *
     * @param \Phalcon\DiInterface $dependencyInjector
     */
    public function registerServices(\Phalcon\DiInterface $dependencyInjector) {
        /** @var Config $config */
        $config = $dependencyInjector->get('config');
        $config->merge(include MODULE_PATH . '/config/config.php');
        $dependencyInjector->setShared('config', $config);

        /** @var View $view */
        $view = $dependencyInjector->get('commonView');
        $view->setViewsDir('../app/modules/backend/views/');
        $dependencyInjector->setShared('view', $view);
    }

}

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
//include APPLICATION_PATH . '/config/modules.php';

//$uri = $di->get('request')->getUri();
//
///** @var \Phalcon\Mvc\Router $router */
//$router = $di->get('router');
//$router->handle($uri);
//
////echo 'ROUTER : ';
////echo $router->getModuleName() . '::';
////echo $router->getControllerName() . '::';
////echo $router->getActionName();
////echo '<br>' . PHP_EOL;
//
//// Initialize module
//include APPLICATION_PATH . '/modules/' . $router->getModuleName() . '/Module.php';
//$moduleClass = sprintf('\Module\%s\Module', ucfirst($router->getModuleName()));
///** @var \Phalcon\Mvc\ModuleDefinitionInterface $module */
//$module = new $moduleClass;
//$module->registerAutoloaders($di);
//$module->registerServices($di);
//
///** @var \Phalcon\Mvc\Dispatcher $dispatcher */
//$dispatcher = $di->get('dispatcher');
//$dispatcher->setModuleName($router->getModuleName());
//$dispatcher->setControllerName($router->getControllerName());
//$dispatcher->setActionName($router->getActionName());
//
//
//// Start the view
///** @var \Phalcon\Mvc\View $view */
//$view = $di->get('view');
//$view->start();
//
//try {
//    $dispatcher->dispatch();
//} catch (\Exception $e) {
//    die('Phalcon dispatcher error: ' . $e->getMessage());
//}
//
//$view->render(
//    $dispatcher->getControllerName(),
//    $dispatcher->getActionName(),
//    $dispatcher->getParams()
//);
//
//$view->finish();
//
///** @var \Phalcon\Http\ResponseInterface $response */
//$response = $di->get('response');
//// Pass the output of the view to the response
//$response->setContent($view->getContent());
//
//// Send the request headers
//$response->sendHeaders();
//
//// Print the response
////echo 'RESPONSE: ';
//echo $response->getContent();


////Get the returned value by the latest executed action
//$response = $dispatcher->getReturnedValue();
//
////Check if the action returned is a 'response' object
//if ($response instanceof Phalcon\Http\ResponseInterface) {
//
//    //Send the request
//    $response->send();
//}
//
///** @var \Phalcon\Http\ResponseInterface $response */
//$response = $di->get('response');
//
////Check if the action returned is a 'response' object
//if ($response instanceof Phalcon\Http\ResponseInterface) {
//
//    //Send the request
//    $response->send();
//}

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
<?php

$di = \Phalcon\Di::getDefault();
$config = $di->get('config');

$di->setShared('logger', function () {
    $logger = new \Phalcon\Logger\Multiple();

    $minutes = sprintf('%02d', floor(date('i') / 15) * 15); // 00, 15, 30, 45
    $filename = LOGS_PATH . '/' . date('Y-m-d_H') . '-' . $minutes . '.log';
    $fileLogger = new \Phalcon\Logger\Adapter\File($filename);
    $fileLogger->setFormatter(new \Games\Library\Logger\Formatter\Line());

    $logger->push($fileLogger);

    return $logger;
});

// TODO: move this function into another place
if (!function_exists('logger')) {
    /**
     * @return \Phalcon\Logger\Adapter
     */
    function logger() {
        return \Phalcon\Di::getDefault()->get('logger');
    }
}

$di->setShared('db', function () use ($config) {
    return new \Phalcon\Db\Adapter\Pdo\Mysql([
        'host' => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname' => $config->database->dbname,
        "charset" => $config->database->charset
    ]);
});

$di->setShared('eventsManager', '\Phalcon\Events\Manager');

$di->set('dispatcher', function () use ($di, $config) {
    $dispatcher = new \Phalcon\Mvc\Dispatcher();
    $dispatcher->setDefaultNamespace($config->dispatcher->defaultNamespace);
    $dispatcher->setEventsManager($di->get('eventsManager'));

    return $dispatcher;
});

$di->set('modelsMetadata', function () {
    return new \Phalcon\Mvc\Model\Metadata\Memory();
});

$di->setShared('security', function () {
    $security = new \Phalcon\Security();
    $security->setWorkFactor(12);

    return $security;
});

$di->setShared('session', function () use ($di) {
    $session = new \Phalcon\Session\Adapter\Files([
        'uniqueId' => $di->get('router')->getModuleName(),
    ]);
    $session->start();

    return $session;
});

$di->setShared('view', function () {
    $view = new \Phalcon\Mvc\View();
    $view->registerEngines([
        ".volt" => function ($view, $di) {
            $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);

            $volt->setOptions([
                'compiledPath' => function ($templatePath) {
                    $filename = str_replace('..', '__', $templatePath);
                    $filename = str_replace('/', '_', $filename);
                    $dir = APPLICATION_PATH . '/cache/' . $filename . '.php';

                    return $dir;
                }
            ]);

            return $volt;
        }
    ]);

    return $view;
});


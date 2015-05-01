<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;

$di->setShared('config', $config);

$di->setShared('db', function () use ($config) {
    return new DbAdapter([
        'host' => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname' => $config->database->dbname,
        "charset" => $config->database->charset
    ]);
});

$di->setShared('eventsManager', '\Phalcon\Events\Manager');

$di->set('dispatcher', function() use ($di) {
    $dispatcher = new \Phalcon\Mvc\Dispatcher();
    $dispatcher->setDefaultNamespace($di->get('config')->dispatcher->defaultNamespace);
    $dispatcher->setEventsManager($di->get('eventsManager'));
    return $dispatcher;
});

$di->set('modelsMetadata', function () {
    return new MetaDataAdapter();
});

$di->setShared('session', function () use ($di) {
    $session = new SessionAdapter([
        'uniqueId' => $di->get('router')->getModuleName(),
    ]);
    $session->start();

    return $session;
});

$di->setShared('commonView', function () {
    $view = new View();
    $view->registerEngines([
        ".volt" => function($view, $di) {
            $volt = new VoltEngine($view, $di);

            $volt->setOptions(array(
                'compiledPath' => function($templatePath) {
                    $filename = str_replace('..', '__', $templatePath);
                    $filename = str_replace('/', '_', $filename);
                    $dir = APPLICATION_PATH . '/cache/' . $filename . '.php';
                    return $dir;
                }
            ));

            return $volt;
        }
    ]);
    return $view;
});
<?php

error_reporting(E_ALL);
ini_set('display_errors', 0);

$env = isset($_SERVER['APPLICATION_ENV']) ? $_SERVER['APPLICATION_ENV'] : 'production';
defined('APPLICATION_ENV') || define('APPLICATION_ENV', $env);

if (in_array(APPLICATION_ENV, ['development', 'testing'])) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(-1);
}

try {

    $application = include __DIR__ . '/../app/bootstrap.php';

    echo $application->handle()->getContent();;

} catch (\Exception $e) {
    $message = 'UNCAUGHT EXCEPTION: ' . $e->getMessage() . ' [' . $e->getFile() . ':' . $e->getLine() . ']';
    if (isset($di) && $di instanceof \Phalcon\Di && $di->has('logger')) {
        $di->get('logger')->emergency($message);
    }
    if (in_array(APPLICATION_ENV, ['development', 'testing'])) {
        echo $message;
    } else {
        echo 'Something wrong. Our developers are working to resolve this problem. Please try your request later. Sorry.';
    }
}

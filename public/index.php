<?php

error_reporting(E_ALL);
ini_set('display_errors', 0);

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

try {

//    include __DIR__ . '/../app/bootstrap.php';
    $application = include __DIR__ . '/../app/bootstrap.php';

    if ($application) {
        $uri = $di->get('request')->getURI();
        $result = $application->handle();
        $result = $result->getContent();
        echo $result;
    }

} catch (\Exception $e) {
    echo $e->getMessage();
}

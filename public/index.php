<?php

error_reporting(E_ALL);
ini_set('display_errors', 0);

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

try {

    $application = include __DIR__ . '/../app/bootstrap.php';

    echo $application->handle()->getContent();;

} catch (\Exception $e) {
    echo $e->getMessage();
}

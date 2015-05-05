<?php

return new \Phalcon\Config([
    'database' => [
        'adapter' => 'Mysql',
        'host' => '127.0.0.1',
        'username' => 'games',
        'password' => 'games_pass',
        'dbname' => 'games',
        'charset' => 'utf8',
    ],

    'application' => [
        'modelsDir' => '../app/models/',
    ],
]);

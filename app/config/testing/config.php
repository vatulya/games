<?php

return new \Phalcon\Config([
    'urlBase' => 'games.testing',
    'moduleUrlBase' => [
        'admin' => 'admin.games.testing',
        'api' => 'api.games.testing',
        'backend' => 'backend.games.testing',
        'frontend' => 'games.testing',
    ],

    'database' => [
        'adapter' => 'Mysql',
        'host' => 'localhost',
        'username' => 'games',
        'password' => 'games_pass',
        'dbname' => 'games',
        'charset' => 'utf8',
    ],
]);

<?php

return new \Phalcon\Config([
    'urlBase' => 'games.com',
    'moduleUrlBase' => [
        'admin' => 'admin.games.com',
        'api' => 'api.games.com',
        'backend' => 'backend.games.com',
        'frontend' => 'games.com',
    ],

    'database' => [
        'adapter' => 'Mysql',
        'host' => 'db.games.com',
        'username' => 'games',
        'password' => 'games_pass',
        'dbname' => 'games',
        'charset' => 'utf8',
    ],

    'mongodb' => [
        'host' => 'mongodb.games.com',
        'db' => 'games',
    ],
]);

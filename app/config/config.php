<?php

return new \Phalcon\Config([
    'urlBase' => 'games.local',

    'database' => [
        'adapter' => 'Mysql',
        'host' => 'localhost',
        'username' => 'games',
        'password' => 'games_pass',
        'dbname' => 'games',
        'charset' => 'utf8',
    ],
]);

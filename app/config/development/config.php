<?php

return new \Phalcon\Config([
    'urlBase' => 'games.local',
    'moduleUrlBase' => [
        'admin' => 'admin.games.local',
        'api' => 'api.games.local',
        'backend' => 'backend.games.local',
        'frontend' => 'games.local',
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

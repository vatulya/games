<?php

$loader = new \Phalcon\Loader();

$loader->registerNamespaces([
    'Games\Module\Api\Controller' => '../app/modules/api/controllers/',
]);

$loader->register();
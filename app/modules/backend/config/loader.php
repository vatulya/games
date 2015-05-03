<?php

$loader = new \Phalcon\Loader();

$loader->registerNamespaces([
    'Games\Module\Backend\Controller' => '../app/modules/backend/controllers/',
]);

$loader->register();
<?php

$loader = new \Phalcon\Loader();

$loader->registerNamespaces([
    'Games\Module\Frontend\Controller' => '../app/modules/frontend/controllers/',
]);

$loader->register();
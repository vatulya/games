<?php

$loader = new \Phalcon\Loader();

$loader->registerNamespaces([
    'Games\Module\Admin\Controller' => '../app/modules/admin/controllers/',
]);

$loader->register();
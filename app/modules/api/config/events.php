<?php

use Phalcon\Di as Di;
use Phalcon\Events\Manager as EventsManager;
use Games\Module\Api\Plugin\Security as Security;

$di = Di::getDefault();

/** @var EventsManager $eventsManager */
$eventsManager = $di->get('eventsManager');

$eventsManager->attach('dispatch:beforeExecuteRoute', new Security());



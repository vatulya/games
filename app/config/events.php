<?php

use Phalcon\Di as Di;
use Phalcon\Events\Manager as EventsManager;
use Games\Plugin\ContextManager as PluginContextManager;

$di = Di::getDefault();

/** @var EventsManager $eventsManager */
$eventsManager = $di->get('eventsManager');

$eventsManager->attach('dispatch:afterDispatchLoop', new PluginContextManager());



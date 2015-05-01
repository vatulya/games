<?php

use Phalcon\Events\Manager as EventsManager;

/** @var EventsManager $eventsManager */
$eventsManager = $di->get('eventsManager');

$eventsManager->attach('dispatch:afterDispatchLoop', new \Games\Plugin\ContextManager());



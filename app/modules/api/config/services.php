<?php

use Phalcon\Di as Di;
use Phalcon\Mvc\View as PhalconView;
use Phalcon\Logger\Multiple as LoggerMultiple;
use Phalcon\Logger\Adapter\File as LoggerAdapterFile;
use Games\Library\Logger\Formatter\Line as FormatterLine;

$di = Di::getDefault();

$di->get('view')->setViewsDir(APPLICATION_PATH . '/modules/api/views/');

/** @var LoggerMultiple $logger */
$filename = LOGS_PATH . '/api/' . date('Y-m-d_H') . '.log';
$fileLogger = new LoggerAdapterFile($filename);
$logFormat = '[%datetime%][%type%] %message%';
$fileLogger->setFormatter(new FormatterLine($logFormat));
$di->get('logger')->push($fileLogger);


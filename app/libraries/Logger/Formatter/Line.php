<?php

namespace Games\Library\Logger\Formatter;

use Games\Library\Datetime;
use Phalcon\Logger as Logger;
use Phalcon\Logger\FormatterInterface as FormatterInterface;
use Phalcon\Mvc\Dispatcher as Dispatcher;
use Phalcon\Di as Di;

class Line implements FormatterInterface
{

    /**
     * @var string
     */
    static protected $activeModule = '';

    static protected $types = [
        Logger::EMERGENCY => 'EMERGENCY',
        Logger::CRITICAL => 'CRITICAL',
        Logger::ALERT => 'ALERT',
        Logger::ERROR => 'ERROR',
        Logger::WARNING => 'WARNING',
        Logger::NOTICE => 'NOTICE',
        Logger::INFO => 'INFO',
        Logger::DEBUG => 'DEBUG',
        Logger::CUSTOM => 'CUSTOM',
        Logger::SPECIAL => 'SPECIAL',
    ];

        /**
     * @var string
     */
    protected $stringFormat = '[%datetime%][%type%][%module%] %message%';

    /**
     * @param string $format
     */
    public function __construct($format = '')
    {
        if (!empty($format)) {
            $this->stringFormat = $format;
        }
    }

    /**
     * Applies a format to a message before sent it to the internal log
     *
     * @param string $message
     * @param int $type
     * @param int $timestamp
     * @param mixed $context
     *
     * @return string
     */
    public function format($message, $type, $timestamp, $context = null) {
        // I don't check types of variables because Phalcon calls this method
        // I can't control this problem
        $data = [
            '%datetime%' => date('Y-m-d H:i:s', $timestamp) . '.' . Datetime::getMicrotime(),
            '%type%' => self::getTypeString($type),
            '%module%' => self::getActiveModule(),
            '%message%' => $message,
        ];

        $logString = str_replace(array_keys($data), array_values($data), $this->stringFormat);
        return $logString;
    }

    /**
     * @return string
     */
    static public function getActiveModule()
    {
        if (empty(self::$activeModule)) {
            /** @var Dispatcher $dispatcher */
            $dispatcher = Di::getDefault()->get('dispatcher');
            self::setActiveModule($dispatcher->getModuleName());
        }
        return self::$activeModule;
    }

    /**
     * @param string $module
     */
    static public function setActiveModule($module)
    {
        if (!is_string($module)) {
            throw new \InvalidArgumentException('Wrong module type. Must be string.');
        }
        self::$activeModule = $module;
    }

    /**
     * @param int $type
     *
     * @return string
     */
    static public function getTypeString($type)
    {
        if (!isset(self::$types[$type])) {
            return 'UNKNOWN TYPE (' . $type . ')';
        }
        return self::$types[$type];
    }

}
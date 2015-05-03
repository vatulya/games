<?php

namespace Games\Library\Logger\Formatter;

use Phalcon\Logger;
use \Phalcon\Logger\FormatterInterface;
use Phalcon\Mvc\Dispatcher;

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
        list ($micro) = explode(' ', microtime());
        $micro = str_replace('0.', '.', $micro);
        $data = [
            '%datetime%' => date('Y-m-d H:i:s') . $micro,
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
            $dispatcher = \Phalcon\Di::getDefault()->get('dispatcher');
            self::$activeModule = $dispatcher->getModuleName();
        }
        return self::$activeModule;
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
<?php

namespace Test\Games\Library\Logger\Formatter;

use Phalcon\Logger as Logger;
use Test\Games\UnitTestCase as UnitTestCase;
use Games\Library\Logger\Formatter\Line as GamesFormatterLine;

class LineTest extends UnitTestCase
{

    /**
     * @param string $format
     * @param string $module
     * @param string $message
     * @param int $type
     *
     * @dataProvider providerTestFormat
     */
    public function testFormatWithoutTimestamp($format, $module, $message, $type, $expectedResult)
    {
        $formatter = new GamesFormatterLine($format);
        $formatter->setActiveModule($module);
        // Timestamp will tested in another test
        $string = $formatter->format($message, $type, 0);
        $this->assertEquals($expectedResult, $string, 'Result must be as expected');
    }

    public function providerTestFormat()
    {
        return [
            [
                'format' => '%type% nothing type',
                'module' => 'module',
                'message' => 'message',
                'type' => Logger::EMERGENCY,
                'expectedResult' => 'EMERGENCY nothing type',
            ],
            [
                'format' => '[%type%][%module%] %message%',
                'module' => 'some module',
                'message' => 'my message',
                'type' => Logger::CRITICAL,
                'expectedResult' => '[CRITICAL][some module] my message',
            ],
        ];
    }

    /**
     * @param int $timestamp
     * @param int $type
     * @param string $typeString
     *
     * @dataProvider providerTestFormatTimestamp
     */
    public function testFormatTimestamp($timestamp, $type, $typeString)
    {
        $formatter = new GamesFormatterLine('[%type%][%datetime%]');
        $string = $formatter->format('', $type, $timestamp);
        $this->assertContains('[' . date('Y-m-d H:i:s', $timestamp), $string, 'Result must contain correct datetime');
        $this->assertContains('[' . $typeString . ']', $string, 'Result must contain correct log type');
    }

    public function providerTestFormatTimestamp()
    {
        return [
            [
                'timestamp' => 0,
                'type' => Logger::ALERT,
                'typeString' => 'ALERT',
            ],
            [
                'timestamp' => 0,
                'type' => Logger::ERROR,
                'typeString' => 'ERROR',
            ],
            [
                'timestamp' => 0,
                'type' => Logger::WARNING,
                'typeString' => 'WARNING',
            ],
            [
                'timestamp' => 0,
                'type' => Logger::NOTICE,
                'typeString' => 'NOTICE',
            ],
            [
                'timestamp' => 0,
                'type' => Logger::INFO,
                'typeString' => 'INFO',
            ],
            [
                'timestamp' => 0,
                'type' => Logger::DEBUG,
                'typeString' => 'DEBUG',
            ],
            [
                'timestamp' => 0,
                'type' => Logger::CUSTOM,
                'typeString' => 'CUSTOM',
            ],
            [
                'timestamp' => 0,
                'type' => Logger::SPECIAL,
                'typeString' => 'SPECIAL',
            ],
        ];
    }

}
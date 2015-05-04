<?php

namespace Test\Games\Library\File;

use Games\Library\File\Loader as GamesFileLoader;
use Phalcon\Config as Config;
use Test\Games\UnitTestCase as UnitTestCase;

class FileTest extends UnitTestCase
{

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testIncludeConfigWhenWrongFilepathAndRequired()
    {
        GamesFileLoader::includeConfig('wrong path', false);
    }

    public function testIncludeConfig()
    {
        $filepath = TEST_PATH . '/_data/requireFileExamples/config.php';

        $config = new Config();
        $this->di->setShared('config', $config);

        $this->assertEquals([], $this->di->get('config')->toArray(), 'Config in DI must be empty');

        GamesFileLoader::setEnvironment('environment');
        GamesFileLoader::includeConfig($filepath);

        $expected = [
            'test key' => 'test value',
            'sub array' => [
                'sub key1' => 'sub value1 environment',
                'sub key2' => 'sub value2 environment',
            ],
            'bool1' => false,
            'environment key' => 'environment value',
        ];
        $this->assertEquals($expected, $this->di->get('config')->toArray(), 'Expected and Actual Configs must be the same');
    }

    public function testIncludeFile()
    {
        $filepath = TEST_PATH . '/_data/requireFileExamples/file.php';

        $this->assertFalse($this->di->has('test1'), 'DI must not contain test data');
        $this->assertFalse($this->di->has('test2 environment'), 'DI must not contain test data');

        GamesFileLoader::setEnvironment('environment');
        GamesFileLoader::includeFile($filepath);

        $this->assertTrue($this->di->has('test1'), 'DI must contain test data');
        $this->assertTrue($this->di->has('test2 environment'), 'DI must contain test data');

        $this->assertEquals('test1', $this->di->get('test1'), 'Check test data in DI');
        $this->assertEquals('test2 environment', $this->di->get('test2 environment'), 'Check environment data in DI');
    }

}
<?php

namespace Test\Games;

use Phalcon\Di;

abstract class UnitTestCase extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Di
     */
    protected $di;

    public function setUp() {
        $this->di = Di::getDefault();
    }

}
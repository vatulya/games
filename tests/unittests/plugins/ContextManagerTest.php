<?php

namespace Test\Games\Plugin;

use Games\Plugin\ContextManager;
use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Mvc\View;
use Test\Games\UnitTestCase;

class ContextManagerTest extends UnitTestCase
{

    /**
     * @var ContextManager
     */
    protected $plugin;

    public function setUp() {
        parent::setUp();

        $this->plugin = new ContextManager();
    }


    public function testAfterDispatchLoopWhenNoAjax()
    {
        $this->plugin = $this->getMockBuilder('\Games\Plugin\ContextManager')
            ->setMethods(['processFormat'])
            ->getMock();

        $this->plugin->expects($this->never())
            ->method('processFormat');

        /** @var Request $request */
        $request = $this->getMockBuilder('Phalcon\Http\Request')->getMock();
        $request->method('isAjax')->willReturn(false);
        $this->di->set('request', $request);

        $this->assertTrue($this->plugin->afterDispatchLoop(), 'method afterDispatchLoop must return true');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAfterDispatchLoopWhenUnknownFormat()
    {
        /** @var Request $request */
        $request = $this->getMockBuilder('Phalcon\Http\Request')->getMock();
        $request->method('isAjax')->willReturn(true);
        $request->method('get')->willReturn('unknown format');
        $this->di->set('request', $request);

        $this->plugin->afterDispatchLoop();
    }

    public function testAfterDispatchLoopWhenFormatHTML()
    {
        /** @var Request $request */
        $request = $this->getMockBuilder('Phalcon\Http\Request')->getMock();
        $request->method('isAjax')->willReturn(true);
        $request->method('get')->willReturn(ContextManager::FORMAT_HTML);
        $this->di->set('request', $request);

        $this->assertTrue($this->plugin->afterDispatchLoop(), 'method afterDispatchLoop must return true');

        /** @var View $view */
        $view = $this->di->get('view');
        $this->assertEquals(View::LEVEL_BEFORE_TEMPLATE, $view->getRenderLevel(), 'check View render level');
    }

    public function testAfterDispatchLoopWhenFormatJSON()
    {
        $request = $this->getMockBuilder('Phalcon\Http\Request')->getMock();
        $request->method('isAjax')->willReturn(true);
        $request->method('get')->willReturn(ContextManager::FORMAT_JSON);
        $this->di->set('request', $request);

        $response = $this->getMockBuilder('Phalcon\Http\Response')
            ->setMethods(['setContentType', 'setContent', 'send'])
            ->getMock();
        $response->expects($this->once())->method('send');
        $this->di->set('response', $response);

        $params = [
            'key1' => 'key2',
            'some parameter' => 'some value',
            'array' => [
                'sub array key' => 'sub array value',
            ],
        ];

        /** @var View $view */
        $view = $this->di->get('view');
        $view->setVars($params);

        $this->assertTrue($this->plugin->afterDispatchLoop(), 'method afterDispatchLoop must return true');

        /** @var Response $response */
        $response = $this->di->get('response');
        $this->assertEquals(json_encode($params), $response->getContent(), 'Response content must be json encoded');

    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAfterDispatchLoopWhenFormatXML()
    {

        // NOTE: format XML is not supported yet

        /** @var Request $request */
        $request = $this->getMockBuilder('Phalcon\Http\Request')->getMock();
        $request->method('isAjax')->willReturn(true);
        $request->method('get')->willReturn(ContextManager::FORMAT_XML);
        $this->di->set('request', $request);

        $this->plugin->afterDispatchLoop();
    }

}
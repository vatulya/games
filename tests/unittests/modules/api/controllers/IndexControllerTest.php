<?php

namespace Test\Games\Module\Api\Controller;

use Phalcon\Mvc\View;
use Test\Games\UnitTestCase as UnitTestCase;
use Games\Module\Api\Controller\IndexController as IndexController;

class IndexControllerTest extends UnitTestCase
{

    /**
     * @var IndexController
     */
    protected $controller;

    public function setUp()
    {
        parent::setUp();

        $this->di->set('view', new View()); // set clear View
        $this->controller = new IndexController();
        $this->controller->setDI($this->di);
        $this->controller->view = $this->di->get('view');
    }

    public function testIndexAction()
    {
        $view = $this->di->get('view');
        $this->controller->indexAction();

        $config = $this->di->get('config');
        $this->assertStringMatchesFormat((string)$config->api->version, (string)$view->api_version, '"api_version" must contains correct value from config');
        $this->assertStringMatchesFormat($config->api->status, (string)$view->status, '"status" must contains correct value from config');
    }

}
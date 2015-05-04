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

        $this->controller = new IndexController();
    }

    public function testIndexAction()
    {
        $view = new View();
        $this->di->set('view', $view); // set clear View
        $this->controller->indexAction();

        $config = $this->di->get('config');
        $this->assertStringMatchesFormat($config->api->version, (string)$view->api_version, '"api_version" must contains correct value from config');
        $this->assertStringMatchesFormat($config->api->status, (string)$view->status, '"status" must contains correct value from config');
    }

}
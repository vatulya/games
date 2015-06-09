<?php

namespace Test\Games\Module\Api\Controller;

use Phalcon\Mvc\View as View;
use Test\Games\UnitTestCase as UnitTestCase;
use Games\Model\Application as ModelApplication;
use Games\Module\Api\Controller\ApplicationsController as ApplicationsController;

class ApplicationsControllerTest extends UnitTestCase
{

    /**
     * @var ApplicationsController
     */
    protected $controller;

    public function setUp() {
        parent::setUp();

        $this->di->set('view', new View()); // set clear View
        $this->controller = new ApplicationsController();
        $this->controller->setDI($this->di);
        $this->controller->view = $this->di->get('view');
    }

    public function testIndexActionIsAliasToListAction() {
        $controller = $this->getMockBuilder('Games\Module\Api\Controller\ApplicationsController')->setMethods(['listAction'])->getMock();
        $controller->expects($this->once())->method('listAction');
        $controller->indexAction();
    }

    public function testListAction() {
        /** @var ModelApplication[] $applicationModels */
        $applicationModels = ModelApplication::find([
            'condition' => 'status IN ("active")',
            'order' => 'title ASC',
        ]);
        $applications = [];
        foreach ($applicationModels as $applicationModel) {
            $applications[] = [
                'id' => $applicationModel->id,
                'title' => $applicationModel->title,
                'code' => $applicationModel->code,
                'status' => $applicationModel->status,
                'description' => $applicationModel->description,
                'url' => $applicationModel->url,
            ];
        }

        $this->controller->listAction();

        $view = $this->di->get('view');

        $this->assertEquals($applications, $view->applications, 'result and database data must be the same');
    }

}
<?php

namespace Test\Games\Module\Api\Controller;

use Phalcon\Mvc\View as View;
use Test\Games\UnitTestCase as UnitTestCase;
use Games\Model\Game as ModelGame;
use Games\Module\Api\Controller\GamesController as GamesController;

class GamesControllerTest extends UnitTestCase
{

    /**
     * @var GamesController
     */
    protected $controller;

    public function setUp() {
        parent::setUp();

        $this->di->set('view', new View()); // set clear View
        $this->controller = new GamesController();
        $this->controller->setDI($this->di);
        $this->controller->view = $this->di->get('view');
    }

    public function testIndexActionIsAliasToListAction() {
        $controller = $this->getMockBuilder('Games\Module\Api\Controller\GamesController')->setMethods(['listAction'])->getMock();
        $controller->expects($this->once())->method('listAction');
        $controller->indexAction();
    }

    public function testListAction() {
        /** @var ModelGame[] $gamesModels */
        $gamesModels = ModelGame::find([
            'condition' => 'status NOT IN ("not active", "deleted")',
            'order' => 'title ASC',
        ]);
        $games = [];
        foreach ($gamesModels as $gamesModel) {
            $games[] = [
                'id' => $gamesModel->id,
                'title' => $gamesModel->title,
                'code' => $gamesModel->code,
                'status' => $gamesModel->status,
                'description' => $gamesModel->description,
                'url' => $gamesModel->url,
            ];
        }

        $this->controller->listAction();

        $view = $this->di->get('view');

        $this->assertEquals($games, $view->games, 'result and database data must be the same');
    }

}
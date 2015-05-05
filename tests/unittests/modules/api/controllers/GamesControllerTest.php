<?php

namespace Test\Games\Module\Api\Controller;

use Games\Model\Games as ModelGames;
use Phalcon\Mvc\View as View;
use Test\Games\UnitTestCase as UnitTestCase;
use Games\Module\Api\Controller\GamesController as GamesController;

class GamesControllerTest extends UnitTestCase
{

    /**
     * @var GamesController
     */
    protected $controller;

    public function setUp()
    {
        parent::setUp();

        $this->di->set('view', new View()); // set clear View
        $this->controller = new GamesController();
        $this->controller->setDI($this->di);
        $this->controller->view = $this->di->get('view');
    }

    public function testIndexActionIsAliasToListAction()
    {
        $controller = $this->getMockBuilder('Games\Module\Api\Controller\GamesController')
            ->setMethods(['listAction'])
            ->getMock();
        $controller->expects($this->once())->method('listAction');
        $controller->indexAction();
    }

    public function testListAction()
    {
        /** @var ModelGames[] $gamesModels */
        $gamesModels = ModelGames::find([
            'condition' => 'status NOT IN ("not active", "deleted")',
            'order' => 'title ASC',
        ]);
        $games = [];
        foreach ($gamesModels as $gamesModel) {
            $games[] = [
                'id' => $gamesModel->getId(),
                'title' => $gamesModel->getTitle(),
                'code' => $gamesModel->getCode(),
                'status' => $gamesModel->getStatus(),
                'description' => $gamesModel->getDescription(),
                'url' => $gamesModel->getUrl(),
            ];
        }

        $this->controller->listAction();

        $view = $this->di->get('view');

        $this->assertEquals($games, $view->games, 'result and database data must be the same');
    }

}
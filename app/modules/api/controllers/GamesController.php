<?php

namespace Games\Module\Api\Controller;

use Games\Model\Games as ModelGames;

class GamesController extends ControllerBase
{

    public function indexAction()
    {
        $this->listAction();
    }

    public function listAction()
    {
        /** @var ModelGames[] $gamesModels */
        $gamesModels = ModelGames::find([
            'condition' => 'status <> "deleted"',
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

        $this->view->setVars([
            'games' => $games,
            'total' => ModelGames::count(['status NOT IN ("not active", "deleted")']),
        ]);
    }

}

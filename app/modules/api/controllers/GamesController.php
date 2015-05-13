<?php

namespace Games\Module\Api\Controller;

use Games\Model\Game as ModelGame;

class GamesController extends ControllerBase
{

    public function indexAction() {
        $this->listAction();
    }

    public function listAction() {
        /** @var ModelGame[] $gamesModels */
        $gamesModels = ModelGame::find([
            'condition' => 'status <> "deleted"',
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

        $this->view->setVars([
            'games' => $games,
            'total' => ModelGame::count(['status NOT IN ("not active", "deleted")']),
        ]);
    }

}

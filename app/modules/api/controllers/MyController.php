<?php

namespace Games\Module\Api\Controller;

class MyController extends ControllerBase
{

    public function indexAction() {
        // nothing for now
    }

    public function infoAction() {
        $game = $this->getGame();
        $this->view->setVars([
            'id' => $game->id,
            'title' => $game->title,
            'code' => $game->code,
            'status' => $game->status,
            'description' => $game->description,
            'url' => $game->url,
        ]);
    }

}

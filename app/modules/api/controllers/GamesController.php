<?php

namespace Games\Module\Api\Controller;

use Games\Model\Application as ModelApplication;
use Games\Model\Application\Game as ModelGame;

class GamesController extends ControllerBase
{

    public function indexAction($applicationCode = null) {
        $this->listAction($applicationCode);
    }

    public function listAction($applicationCode = null) {
        $params = [];

        $userId = $this->request->get('user_id');
        if ($userId) {
            $params['user_id'] = $userId;
        }

        $gamesModels = null;
        if ($applicationCode) {
            $application = ModelApplication::findByCode($applicationCode);
            if ($application) {
                $gamesModels = $application->getGames($params);
            }
        } else {
            $gamesModels = ModelGame::find($params);
        }

        $this->view->setVars([
            'games' => $gamesModels ? $gamesModels->toArray() : [],
        ]);
    }

    public function createAction($applicationCode) {
        $application = ModelApplication::findByCode($applicationCode);
        if (!$application) {
            throw new \RuntimeException('Wrong application code "' . $applicationCode . '"');
        }

        $gameModel = new ModelGame();
        $gameModel->save([
            'applications_id' => $application->id,
        ]);
        $this->view->setVars($gameModel->toArray());
    }

}


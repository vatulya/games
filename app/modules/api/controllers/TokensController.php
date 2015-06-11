<?php

namespace Games\Module\Api\Controller;

use Games\Model\Application as ModelApplication;
use Games\Model\Application\Game as ModelGame;
use Games\Collection\Api\Token as CollectionToken;

class TokensController extends ControllerBase
{

    public function createAction() {
        $application = $this->getApplication();

        $token = new CollectionToken();
        $token->api_key = $application->getApiKey()->api_key;
        $token->save();

        $this->view->setVars([
            'token' => $token->token,
        ]);
    }

}


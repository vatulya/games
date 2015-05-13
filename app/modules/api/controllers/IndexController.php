<?php

namespace Games\Module\Api\Controller;

class IndexController extends ControllerBase
{

    public function indexAction() {
        $config = $this->getDI()->get('config');
        $this->view->setVars([
            'api_version' => $config->api->version,
            'status' => $config->api->status,
        ]);
    }

}

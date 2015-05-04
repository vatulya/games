<?php

namespace Games\Module\Api\Controller;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $config = $this->getDI()->get('config');
        $this->view->api_version = $config->api->version;
        $this->view->status = $config->api->status;
    }

}

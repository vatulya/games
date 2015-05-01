<?php

namespace Games\Module\Api\Controller;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        // nothing
        $this->view->message = 'api::index::index';
    }

}

<?php

namespace Games\Module\Api\Controller;

class MyController extends ControllerBase
{

    public function indexAction() {
        // nothing for now
    }

    public function infoAction() {
        $application = $this->getApplication();
        $this->view->setVars([
            'id' => $application->id,
            'title' => $application->title,
            'code' => $application->code,
            'status' => $application->status,
            'description' => $application->description,
            'url' => $application->url,
        ]);
    }

}

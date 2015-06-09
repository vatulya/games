<?php

namespace Games\Module\Api\Controller;

use Games\Model\Application as ModelApplication;

class ApplicationsController extends ControllerBase
{

    public function indexAction() {
        $this->listAction();
    }

    public function listAction() {
        /** @var ModelApplication[] $applicationModels */
        $applicationModels = ModelApplication::find([
            'condition' => 'status <> "deleted"',
            'order' => 'title ASC',
        ]);

        $this->view->setVars([
            'applications' => $applicationModels->toArray(),
            'total' => ModelApplication::count(['status NOT IN ("not active", "deleted")']),
        ]);
    }

}

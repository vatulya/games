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
        $applications = [];
        foreach ($applicationModels as $applicationModel) {
            $applications[] = [
                'id' => $applicationModel->id,
                'title' => $applicationModel->title,
                'code' => $applicationModel->code,
                'status' => $applicationModel->status,
                'description' => $applicationModel->description,
                'url' => $applicationModel->url,
            ];
        }

        $this->view->setVars([
            'applications' => $applications,
            'total' => ModelApplication::count(['status NOT IN ("not active", "deleted")']),
        ]);
    }

}

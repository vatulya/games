<?php

namespace Games\Module\Api\Controller;

use Phalcon\Http\Response as Response;
use Phalcon\Mvc\Controller as Controller;
use Phalcon\Mvc\ViewInterface as ViewInterface;
use Games\Model\Application as ModelApplication;

/**
 * @property ViewInterface $view
 */
class ControllerBase extends Controller
{

    const FORMAT_XML = 'xml';
    const FORMAT_JSON = 'json';

    /**
     * @var ModelApplication|null
     */
    protected $application;

    /**
     * @return ModelApplication|null
     */
    public function getApplication() {
        return $this->application;
    }

    /**
     * @param ModelApplication $application
     */
    public function setApplication(ModelApplication $application) {
        $this->application = $application;
    }

    public function afterExecuteRoute() {
        $format = $this->request->get('format');
        switch ($format) {
            case self::FORMAT_XML:
                // Here will be XML encoding
                $content = json_encode([
                    'error' => 1,
                    'message' => 'Sorry. XML response doesn\'t support yet',
                ]);
                break;

            case self::FORMAT_JSON: // as default
            default:
                $content = json_encode($this->view->getParamsToView());
                break;
        }

        $this->view->disable();

        /** @var Response $response */
        $response = $this->response;
        $response->setContentType('application/json', 'UTF-8');
        $response->setContent($content);

        $response->send();
    }

}

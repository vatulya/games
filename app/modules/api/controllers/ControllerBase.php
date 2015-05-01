<?php

namespace Games\Module\Api\Controller;

use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\ViewInterface;

/**
 * @property ViewInterface $view
 */
class ControllerBase extends Controller
{

    const FORMAT_XML = 'xml';
    const FORMAT_JSON = 'json';

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

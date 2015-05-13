<?php

namespace Games\Module\Api\Controller;

use Phalcon\Http\Response as Response;
use Phalcon\Mvc\Controller as Controller;
use Phalcon\Mvc\ViewInterface as ViewInterface;
use Games\Model\Game as Game;

/**
 * @property ViewInterface $view
 */
class ControllerBase extends Controller
{

    const FORMAT_XML = 'xml';
    const FORMAT_JSON = 'json';

    /**
     * @var Game|null
     */
    protected $game;

    /**
     * @return Game|null
     */
    public function getGame() {
        return $this->game;
    }

    /**
     * @param Game $game
     */
    public function setGame(Game $game) {
        $this->game = $game;
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

<?php

namespace Games\Module\Api\Plugin;

use Phalcon\Events\Event as Event;
use Phalcon\Http\Request as Request;
use Phalcon\Mvc\Dispatcher as Dispatcher;
use Phalcon\Mvc\User\Plugin as Plugin;
use Games\Model\Game as Game;
use Games\Model\Game\ApiKey as ApiKey;
use Games\Module\Api\Controller\ControllerBase as ControllerBase;

class Security extends Plugin
{

    const KEY_API_KEY = 'api_key';
    const KEY_CHECK_SUM = 'check_sum';

    /**
     * ['controller', 'action']
     * @var array
     */
    protected $publicRoutes = [
        ['index'],
    ];

    /**
     * @param Event $event
     * @param Dispatcher $dispatcher
     *
     * @return bool
     * @throws \RuntimeException
     */
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher) {
        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();
        if ($this->isAllowedRoute($controller, $action, $this->publicRoutes)) {
            return true;
        }

        /** @var Request $request */
        $request = $this->getDI()->get('request');
        $params = $request->get();

        $apiKeyModel = $this->getApiKey($params);

        $this->checkParams($params, $apiKeyModel->private_key);

        /** @var Game $game */
        $game = $apiKeyModel->getGame();

        /** @var ControllerBase $activeController */
        $activeController = $dispatcher->getActiveController();
        $activeController->setGame($game);

        $permissions = $game->getPermissionsCompiled();
        if ($this->isAllowedRoute($controller, $action, $permissions)) {
            return true;
        }

        throw new \RuntimeException('Permission denied');
    }

    /**
     * @param string $controller
     * @param string $action
     * @param array $routes
     *
     * @return bool
     */
    public function isAllowedRoute($controller, $action, $routes) {
        if (in_array([$controller, $action], $routes)) {
            return true;
        }
        if (in_array([$controller], $routes)) {
            return true;
        }

        return false;
    }

    /**
     * @param array $params
     * @param string $privateKey
     *
     * @return bool
     * @throws \RuntimeException
     */
    public function checkParams($params, $privateKey) {
        if (!isset($params[self::KEY_CHECK_SUM])) {
            throw new \RuntimeException('Wrong checksum');
        }

        $checkSum = $params[self::KEY_CHECK_SUM];
        unset($params[self::KEY_CHECK_SUM]);

        ksort($params);

        $hash = md5(implode('', $params) . $privateKey);
        if ($checkSum !== $hash) {
            throw new \RuntimeException('Wrong checksum');
        }

        return true;
    }

    /**
     * @param array $params
     *
     * @return ApiKey
     */
    public function getApiKey($params) {
        if (!isset($params[self::KEY_API_KEY])) {
            throw new \RuntimeException('API key is required');
        }

        $apiKey = $params[self::KEY_API_KEY];

        /** @var ApiKey $apiKeyModel */
        $apiKeyModel = ApiKey::findFirst(['api_key' => $apiKey]);
        if (!$apiKeyModel) {
            throw new \RuntimeException('Wrong API key');
        }

        return $apiKeyModel;
    }

}

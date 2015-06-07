<?php

namespace Games\Module\Api\Plugin;

use Phalcon\Events\Event as Event;
use Phalcon\Http\Request as Request;
use Phalcon\Mvc\Dispatcher as Dispatcher;
use Phalcon\Mvc\User\Plugin as Plugin;
use Games\Module\Api\Controller\ControllerBase as ControllerBase;
use Games\Model\Application as Application;
use Games\Model\Application\ApiKey as ApplicationApiKey;

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

        /** @var Application $application */
        $application = $apiKeyModel->getApplication();

        /** @var ControllerBase $activeController */
        $activeController = $dispatcher->getActiveController();
        $activeController->setApplication($application);

        $permissions = $application->getPermissionsCompiled();
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

        $hash = md5(http_build_query($params) . $privateKey);
        if ($checkSum !== $hash) {
            throw new \RuntimeException('Wrong checksum');
        }

        return true;
    }

    /**
     * @param array $params
     *
     * @return ApplicationApiKey
     */
    public function getApiKey($params) {
        if (!isset($params[self::KEY_API_KEY])) {
            throw new \RuntimeException('API key is required');
        }

        $apiKey = $params[self::KEY_API_KEY];

        /** @var ApplicationApiKey $apiKeyModel */
        $apiKeyModel = ApplicationApiKey::findFirst(['api_key' => $apiKey]);
        if (!$apiKeyModel) {
            throw new \RuntimeException('Wrong API key');
        }

        return $apiKeyModel;
    }

}

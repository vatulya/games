<?php

namespace Games\Module\Api\Plugin;

use Games\Model\Application;
use Phalcon\Events\Event as Event;
use Phalcon\Http\Request as Request;
use Phalcon\Mvc\Dispatcher as Dispatcher;
use Phalcon\Mvc\User\Plugin as Plugin;
use Games\Module\Api\Controller\ControllerBase as ControllerBase;
use Games\Model\Application as ModelApplication;
use Games\Model\Application\ApiKey as ApplicationApiKey;
use Games\Collection\Api\Token as CollectionApiToken;

class Security extends Plugin
{

    const KEY_API_KEY = 'api_key';
    const KEY_CHECK_SUM = 'check_sum';
    const KEY_PROTECTED_TOKEN = 'token';

    /**
     * ['controller', 'action']
     * @var array
     */
    protected $publicRoutes = [
        ['applications', 'index'],
        ['applications', 'list'],
        ['index'],
    ];

    /**
     * @var array
     */
    protected $protectedRoutes = [
        ['games', 'create'],
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
        if ($this->checkRoute($controller, $action, $this->publicRoutes)) {
            return true;
        }

        /** @var Request $request */
        $request = $this->getDI()->get('request');
        /** @var array $params */
        $params = $request->get();

        $apiKeyModel = $this->getApiKey($params);

        $this->checkParams($params, $apiKeyModel->private_key);

        /** @var ModelApplication $application */
        $application = $apiKeyModel->getApplication();

        /** @var ControllerBase $activeController */
        $activeController = $dispatcher->getActiveController();
        $activeController->setApplication($application);

        $permissions = $application->getPermissionsCompiled();
        if ($this->checkRoute($controller, $action, $permissions)) { // check api_key permissions
            if (!$this->checkRoute($controller, $action, $this->protectedRoutes)) { // check if this route non-protected
                return true;
            }
            if ($this->checkToken($params, $apiKeyModel)) {
                return true;
            }
            throw new \RuntimeException('Permission denied. Wrong token.');
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
    public function checkRoute($controller, $action, $routes) {
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
            throw new \RuntimeException('Parameter "check_sum" is required');
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
     * @param ApplicationApiKey $apiKey
     *
     * @return bool
     * @throws \RuntimeException
     */
    public function checkToken($params, ApplicationApiKey $apiKey)
    {
        if (!isset($params[self::KEY_PROTECTED_TOKEN])) {
            throw new \RuntimeException('This API path is protected. Parameter "token" is required. Call /token/create before.');
        }
        $token = $params[self::KEY_PROTECTED_TOKEN];
        unset($params[self::KEY_PROTECTED_TOKEN]);

        $modelToken = CollectionApiToken::findFirst([
            [
                'token' => $token,
                'api_key' => $apiKey->api_key,
            ],
        ]);
        if (!$modelToken) {
            throw new \RuntimeException('Wrong token');
        }

        if ($modelToken->status == CollectionApiToken::STATUS_ACTIVE) {
            $modelToken->status = CollectionApiToken::STATUS_USED;
            $modelToken->save();
            return true;
        }

        throw new \RuntimeException('Wrong token status: "' . $modelToken->status . '"');
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

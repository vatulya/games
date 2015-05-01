<?php

namespace Games\Plugin;

use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\View;

class ContextManager extends Plugin
{

    const FORMAT_HTML = 'html';
    const FORMAT_JSON = 'json';
    const FORMAT_XML = 'xml';

    /**
     * @return bool
     */
    public function afterDispatchLoop() {
        /** @var Request $request */
        $request = $this->getDI()->get('request');
        if ($request->isAjax()) {
            $format = $request->get('format', null, self::FORMAT_JSON);
            $this->processFormat($format);
        }

        return true;
    }

    /**
     * @param $format
     *
     * @return bool
     */
    public function processFormat($format) {
        if (!in_array($format, $this->getAllowedFormats())) {
            throw new \InvalidArgumentException('Wrong format "' . $format . '". Allowed formats: ' . implode(', ', $this->getAllowedFormats()));
        }

        $method = 'processFormat' . strtoupper($format);
        $this->$method();
    }

    public function processFormatHTML() {
        /** @var View $view */
        $view = $this->getDi()->get('view');
        $view->setRenderLevel(View::LEVEL_BEFORE_TEMPLATE); // or LEVEL_ACTION_VIEW
    }

    public function processFormatJSON() {
        /** @var View $view */
        $view = $this->getDi()->get('view');
        $view->disable();

        $content = json_encode($view->getParamsToView());

        /** @var Response $response */
        $response = $this->getDI()->get('response');
        $response->setContentType('application/json', 'UTF-8');
        $response->setContent($content);

        $response->send();
    }

    public function processFormatXML() {
        // TODO: finish this method
        return true;
    }

    /**
     * @return array
     */
    public function getAllowedFormats() {
        return [
            self::FORMAT_HTML,
            self::FORMAT_JSON,
            self::FORMAT_XML
        ];
    }

}
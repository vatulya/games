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

    /**
     * HTML format must prepare View params
     * View must not render layouts and render only action template
     */
    public function processFormatHTML() {
        /** @var View $view */
        $view = $this->getDi()->get('view');
        $view->setRenderLevel(View::LEVEL_BEFORE_TEMPLATE); // or LEVEL_ACTION_VIEW
    }

    /**
     * JSON format must prepare params to View, encode them into JSON string
     * and return to the client
     */
    public function processFormatJSON() {
        /** @var View $view */
        $view = $this->getDi()->get('view');

        /** @var Response $response */
        $response = $this->getDI()->get('response');
        $response->setJsonContent($view->getParamsToView());
        $response->send();
    }

    /**
     * @return array
     */
    public function getAllowedFormats() {
        return [
            self::FORMAT_HTML,
            self::FORMAT_JSON,
//            self::FORMAT_XML
        ];
    }

}
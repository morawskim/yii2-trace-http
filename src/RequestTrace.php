<?php

namespace mmo\TraceHttp;

use yii\web\Application;
use yii\base\Event;
use yii\helpers\VarDumper;
use yii\log\Logger;
use yii\web\Request;

class RequestTrace implements TraceInterface
{
    public $log_level = Logger::LEVEL_TRACE;
    public $log_category = 'http_request';

    public function register(Application $app)
    {
        $app->on(Application::EVENT_BEFORE_REQUEST, function(Event $event) {
            $request = \Yii::$app->getRequest();
            $message = $this->requestToString($request);
            \Yii::getLogger()->log($message, $this->log_level, $this->log_category);
        });
    }

    /**
     * @param Request $req
     * @return string
     */
    protected function requestToString(Request $req)
    {
        $body = $req->getRawBody();
        $headersArray = $req->getHeaders()->toArray();

        $headers = '';
        foreach ($headersArray as $headerName => $headerValue) {
            $headers .= $headerName . ': ' . str_replace("\n", '', VarDumper::dumpAsString($headerValue));
            $headers .= PHP_EOL;
        }
        $headers = trim($headers);

        $message = $req->userIP . ' ' . $req->method . ' ' . $req->url;
        $message .= "\n";
        $message .= $headers;
        $message .= "\n\n";
        $message .= $body;
        return $message;
    }
}
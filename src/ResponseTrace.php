<?php

namespace mmo\TraceHttp;

use yii\base\Event;
use yii\helpers\VarDumper;
use yii\log\Logger;
use yii\web\Application;
use yii\web\Response;

class ResponseTrace implements TraceInterface
{
    public $log_level = Logger::LEVEL_TRACE;
    public $log_category = 'http_response';

    public function register(Application $app)
    {
        $res = $app->getResponse();
        $res->on(\yii\web\Response::EVENT_AFTER_PREPARE, function(Event $event) {
            $request  = \Yii::$app->getRequest();
            $response = \Yii::$app->getResponse();
            $message = $request->userIP . ' ' . $request->method . ' ' . $request->url;
            $message .= "\n";
            $message .= $this->responseToString($response);
            \Yii::getLogger()->log($message, $this->log_level, $this->log_category);
        });
    }

    protected function responseToString(Response $response)
    {
        $headersArray = $response->headers->toArray();
        $headers = '';
        foreach ($headersArray as $headerName => $headerValue) {
            $headers .= $headerName . ': ' . str_replace("\n", '', VarDumper::dumpAsString($headerValue));
            $headers .= PHP_EOL;
        }
        $headers = trim($headers);

        $message = $response->statusCode . ' ' . $response->statusText;
        $message .= "\n";
        $message .= $headers;
        $message .= "\n\n";
        $message .= $response->content;

        return $message;
    }
}
<?php

namespace mmo\TraceHttp;

use yii\base\Application;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public $request_trace  = [];
    public $response_trace = [];

    public function bootstrap($app)
    {
        if (!$app instanceof \yii\web\Application) {
            return;
        }

        if (!empty($this->request_trace)) {
            /** @var RequestTrace $requestTrace */
            $requestTrace = \Yii::createObject($this->request_trace);
            if (!$requestTrace instanceof TraceInterface) {
                throw new \InvalidArgumentException(sprintf(''));
            }
            $requestTrace->register($app);
        }

        if (!empty($this->response_trace)) {
            /** @var ResponseTrace $responseTrace */
            $responseTrace = \Yii::createObject($this->response_trace);
            if (!$responseTrace instanceof TraceInterface) {
                throw new \InvalidArgumentException(sprintf(''));
            }
            $responseTrace->register($app);
        }
    }
}
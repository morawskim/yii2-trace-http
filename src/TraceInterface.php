<?php

namespace mmo\TraceHttp;

use yii\web\Application;

interface TraceInterface
{
    public function register(Application $application);
}
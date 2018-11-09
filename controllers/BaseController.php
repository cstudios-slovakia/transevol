<?php

namespace app\controllers;

use yii\web\Request;
use yii\web\Controller;

class BaseController extends Controller
{

    /**
     * @return Request
     */
    protected function request() : Request
    {
        return \Yii::$app->request;
    }

}

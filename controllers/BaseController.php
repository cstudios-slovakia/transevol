<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Request;
use yii\web\Controller;

class BaseController extends Controller
{
//    public $layout = false;
    /**
     * @return Request
     */
    protected function request() : Request
    {
        return \Yii::$app->request;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                   
                ],
            ],
        ];
    }
}

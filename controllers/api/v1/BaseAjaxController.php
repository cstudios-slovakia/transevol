<?php

namespace app\controllers\api\v1;

use app\controllers\BaseController;
use yii\web\HttpException;

class BaseAjaxController extends BaseController
{


    protected function checkIsAjaxRequest()
    {
        if ( ! \Yii::$app->request->isAjax){
            throw new HttpException(403, 'Action not allowed.');
        }

        return true;
    }

}
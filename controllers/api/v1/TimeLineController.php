<?php

namespace app\controllers\api\v1;

use app\controllers\BaseController;
use app\support\Timeline\TimeLineDataBuilder;
use yii\web\HttpException;

class TimeLineController extends BaseAjaxController
{

    public function actionRenderableData()
    {
        $isAjax = $this->checkIsAjaxRequest();

        $timeLineDataBuilder = new TimeLineDataBuilder();

        if ($isAjax){

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            return $timeLineDataBuilder->renderableData();
        }
    }

}
<?php

namespace app\controllers\api\v1;

class VehicleDefiniatorController extends \yii\web\Controller
{
    const VEHICLE_ID_KEY = 'vehicleId';
    const TIMELINE_FROM_KEY = 'timelineFrom';
    const TIMELINE_UNTIL_KEY = 'timelineUntil';

    public function actionTimelineModificator()
    {
        $session = \Yii::$app->session;

        $vehicleId = (int) \Yii::$app->request->post(self::VEHICLE_ID_KEY);
        $timelineFrom =  \Yii::$app->request->post(self::TIMELINE_FROM_KEY);
        $timelineUntil =   \Yii::$app->request->post(self::TIMELINE_UNTIL_KEY);

        $session->set(self::VEHICLE_ID_KEY,(int) $vehicleId);
        $session->set(self::TIMELINE_FROM_KEY, $timelineFrom);
        $session->set(self::TIMELINE_UNTIL_KEY, $timelineUntil);


    }

}

<?php

namespace app\controllers\api\v1;

use app\support\Timeline\Intervals\SessionDefinedIntervals;
use app\support\Timeline\SessionDefinedVehicle;
use app\support\Timeline\TimeLineIntervalBuilder;
use app\support\Timeline\TimeLineVehicleBuilder;
use app\support\Transporter\IntervalParts;

class VehicleDefiniatorController extends \yii\web\Controller
{
//    const VEHICLE_ID_KEY = 'vehicleId';
//    const TIMELINE_FROM_KEY = TimeLineIntervalBuilder::TIMELINE_FROM_KEY;
//    const TIMELINE_UNTIL_KEY = TimeLineIntervalBuilder::TIMELINE_UNTIL_KEY;

    public function actionTimelineModificator()
    {

        $vehicleId      = (int) \Yii::$app->request->post(SessionDefinedVehicle::TIMELINE_VEHICLE_KEY);
        $timeLineFrom   =  \Yii::$app->request->post(TimeLineIntervalBuilder::TIMELINE_FROM_KEY);
        $timeLineUntil  =   \Yii::$app->request->post(TimeLineIntervalBuilder::TIMELINE_UNTIL_KEY);

        $sessionDefinedIntervals = new SessionDefinedIntervals();
        $sessionDefinedIntervals->setIntervalNode(TimeLineIntervalBuilder::TIMELINE_FROM_KEY, $timeLineFrom);
        $sessionDefinedIntervals->setIntervalNode(TimeLineIntervalBuilder::TIMELINE_UNTIL_KEY, $timeLineUntil);

        new TimeLineIntervalBuilder(new IntervalParts(), $sessionDefinedIntervals);

        $sessionDefinedVehicle = new SessionDefinedVehicle();
        $sessionDefinedVehicle->defineVehicleId($vehicleId);

    }

}

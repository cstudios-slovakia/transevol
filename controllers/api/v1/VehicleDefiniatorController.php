<?php

namespace app\controllers\api\v1;


use app\support\Timeline\CalculationIntervalBuilder;
use app\support\Timeline\Calculations\CumulativeCalculation;
use app\support\Timeline\Intervals\SessionDefinedIntervals;
use app\support\Timeline\SessionDefinedVehicle;
use app\support\Timeline\TimeLineIntervalBuilder;
//use app\support\Timeline\TimeLineVehicleBuilder;
use app\support\Transporter\IntervalParts;

use yii\web\HttpException;

class VehicleDefiniatorController extends BaseAjaxController
{


    public function actionTimelineModificator()
    {
        $this->checkIsAjaxRequest();

        $vehicleId      = (int) \Yii::$app->request->post(SessionDefinedVehicle::TIMELINE_VEHICLE_KEY);
        $timeLineFrom   =  \Yii::$app->request->post(TimeLineIntervalBuilder::TIMELINE_FROM_KEY);
        $timeLineUntil  =   \Yii::$app->request->post(TimeLineIntervalBuilder::TIMELINE_UNTIL_KEY);

        $sessionDefinedIntervals = new SessionDefinedIntervals();
        $sessionDefinedIntervals->setIntervalNode(TimeLineIntervalBuilder::TIMELINE_FROM_KEY, $timeLineFrom);
        $sessionDefinedIntervals->setIntervalNode(TimeLineIntervalBuilder::TIMELINE_UNTIL_KEY, $timeLineUntil);

        new TimeLineIntervalBuilder(new IntervalParts(), $sessionDefinedIntervals);

        $sessionDefinedVehicle = new SessionDefinedVehicle();
        $sessionDefinedVehicle->defineVehicleId($vehicleId);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return [
            'vehicleId'     => $sessionDefinedVehicle->getDefinedVehicleId(),
            'timeLineFrom'  => $sessionDefinedIntervals->getIntervalNodeFrom(),
            'timeLineUntil'  => $sessionDefinedIntervals->getIntervalNodeTo(),
        ];

    }

    public function actionCalculator()
    {
        $this->checkIsAjaxRequest();

        $vehicleId          = (int) \Yii::$app->request->post(SessionDefinedVehicle::TIMELINE_VEHICLE_KEY);
        $calculateFrom      =  \Yii::$app->request->post(CalculationIntervalBuilder::TIMELINE_FROM_KEY);
        $calculateUntil     =   \Yii::$app->request->post(CalculationIntervalBuilder::TIMELINE_UNTIL_KEY);

        $sessionDefinedIntervals = new SessionDefinedIntervals();
        $sessionDefinedIntervals->setIntervalNode(CalculationIntervalBuilder::TIMELINE_FROM_KEY, $calculateFrom);
        $sessionDefinedIntervals->setIntervalNode(CalculationIntervalBuilder::TIMELINE_UNTIL_KEY, $calculateUntil);

        $calculationIntervalBuilder = new CalculationIntervalBuilder(new IntervalParts(), $sessionDefinedIntervals);

        $sessionDefinedVehicle  = new SessionDefinedVehicle();
        $sessionDefinedVehicle->defineVehicleId($vehicleId);

//        $statistics             = \Yii::$app->runAction('/vehicles/statistics',['id' => $vehicleId = $sessionDefinedVehicle->getDefinedVehicleId()]);
        $calc             = \Yii::$app->runAction('/transporter/dev');

//        $calculationIntervalInHours     = $calculationIntervalBuilder->getIntervalIn('hours');

//        $cumulatioveHourlyCosts     = CumulativeCalculation::make($calculationIntervalInHours, $statistics['statistics']['hourly_abs_costs']);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return [
            'vehicleId'         => $sessionDefinedVehicle->getDefinedVehicleId(),
            'calculateFrom'     => $sessionDefinedIntervals->getIntervalNodeFrom(CalculationIntervalBuilder::TIMELINE_FROM_KEY),
            'calculateUntil'    => $sessionDefinedIntervals->getIntervalNodeTo(CalculationIntervalBuilder::TIMELINE_UNTIL_KEY),
//            'statistics'        => $statistics,
//            'calculations'      => [
//                'interval'  => [
//                    'inMinutes' => $calculationIntervalBuilder->getIntervalIn('minutes'),
//                    'inHours' => $calculationIntervalInHours
//                ],
//                'cumulative'    => [
//                    'hourlyCosts'   => $cumulatioveHourlyCosts->calculate()
//                ]
//            ]
            'calc'      => $calc
        ];

    }

    protected function checkIsAjaxRequest()
    {
        if ( ! \Yii::$app->request->isAjax){
            throw new HttpException(403, 'Action not allowed.');
        }
    }

    public function actionVehicleCostCalculatedStatistics(int $id, array $options = [])
    {
        \Yii::$app->runAction('/vehicles/statistics',['id' => $id,'options' => $options]);
    }

}

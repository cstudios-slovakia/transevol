<?php

namespace app\controllers;

use app\models\Calculations\TimeLine\GoingSectionUnit;
use app\models\Drivers;
use app\models\Goings;
use app\models\TimelineDriver;
use app\models\TimelineVehicle;
use app\models\Transporter;
use app\models\TransporterParts;
use app\support\Timeline\CalculationIntervalBuilder;
use app\support\Timeline\Collectors\TimelineDriverCollector;
use app\support\Timeline\Collectors\TimelineGoingsCollector;
use app\support\Timeline\Collectors\TimelineTransportCollector;
use app\support\Timeline\Collectors\TimelineVehicleCollector;
use app\support\Timeline\Filter\SectionGoingsInTimeLine;
use app\support\Timeline\Filter\TimeLineGoings;
use app\support\Timeline\Filter\TimeLineTrasporterParts;
use app\support\Timeline\Intervals\SessionDefinedIntervals;
use app\support\Timeline\SessionDefinedVehicle;
use app\support\Timeline\TimeLineDataBuilder;
use app\support\Timeline\TimeLineIntervalBuilder;
use app\support\Timeline\TimeLineVehicleBuilder;
use app\support\Transporter\DateTimeIntervalDetector;
use app\support\Transporter\IntervalFormatter;
use app\support\Transporter\IntervalParts;
use app\support\Vehicles\Relations\VehicleRelationAssistance;
use Carbon\Carbon;
use PharIo\Manifest\Url;
use SebastianBergmann\CodeCoverage\Driver\Driver;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\db\mssql\PDO;
use yii\db\Query;
use app\controllers\api\v1\BaseAjaxController;

class TransporterController extends BaseAjaxController
{

    public function actionDev()
    {

        $sectionGoingsOnTimeline    = new SectionGoingsInTimeLine();
        $goingsInSection            = $sectionGoingsOnTimeline->run();
        $calculationFrom            = $sectionGoingsOnTimeline->getTimeLineFrom();
        $calculationUntil           = $sectionGoingsOnTimeline->getTimeLineUntil();
        $intervalBuilder = $sectionGoingsOnTimeline->getIntervalBuilder();

        $goingSectionUnits = collect($goingsInSection)->map(function($goingData) use ($calculationFrom, $calculationUntil, $intervalBuilder){
            $goingSectionUnit = new GoingSectionUnit();
            $goingSectionUnit->load([
                'going_from'                => Carbon::createFromFormat('Y-m-d H:i:s', $goingData['going_from'])->format('Y-m-d H:i'),
                'going_until'               => Carbon::createFromFormat('Y-m-d H:i:s', $goingData['going_until'])->format('Y-m-d H:i'),
                'sectionPosition'           => $goingData['position_status'],
                'calculationFrom'           => $calculationFrom,
                'calculationUntil'          => $calculationUntil,
                'intervalMinutes'           => $goingData['interval_minutes'],
                'id'                        => $goingData['id'],
                'sectionIntervalBuilder'    => $intervalBuilder
            ], '');

            return $goingSectionUnit;
        });

        $goingSectionUnits->each(function(GoingSectionUnit $goingSectionUnit){
            dump($goingSectionUnit->buildHourlyIndexedElapsedTime());
        });



        dd($goingSectionUnits);
    }

    public function actionViewer()
    {

//        $isAjax = $this->checkIsAjaxRequest();

        $timeLineDataBuilder = new TimeLineDataBuilder();
//
//        if ($isAjax){
//
//            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//
//            return $timeLineDataBuilder->renderableData();
//        }


        return $this->render('viewer', $timeLineDataBuilder->renderableData());
    }

    protected function viewerRedirector(array $params)
    {
        $route = ['/transporter/viewer'];

        return $this->redirect(\yii\helpers\Url::toRoute(array_merge($route,$params)));
    }


}

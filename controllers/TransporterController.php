<?php

namespace app\controllers;

use app\models\Drivers;
use app\models\Goings;
use app\models\TimelineDriver;
use app\models\TimelineVehicle;
use app\models\Transporter;
use app\models\TransporterParts;
use app\support\Timeline\Collectors\TimelineDriverCollector;
use app\support\Timeline\Collectors\TimelineGoingsCollector;
use app\support\Timeline\Collectors\TimelineTransportCollector;
use app\support\Timeline\Collectors\TimelineVehicleCollector;
use app\support\Timeline\Filter\TimeLineGoings;
use app\support\Timeline\Filter\TimeLineTrasporterParts;
use app\support\Timeline\Intervals\SessionDefinedIntervals;
use app\support\Timeline\SessionDefinedVehicle;
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
use yii\db\Query;


class TransporterController extends BaseController
{



    public function actionViewer()
    {
        // collect every owned vehicles, used in time line
        $vehicleSelectOptions = VehicleRelationAssistance::ownedVehicles();

        // we check vehicleId in first time too,
        // first vehicle should be used
        $definedVehicleId = array_first(array_keys($vehicleSelectOptions));

        // session must have defined vehicleID
        $sessionDefinedVehicle  = new SessionDefinedVehicle();
        $sessionDefinedVehicle->defineVehicleId($definedVehicleId);

        // for timeline define start and end date/datetime
        // if session does not contains timeline interval data, last 2 days should be used
        $timeLineIntervalDetector = new TimeLineIntervalBuilder(new IntervalParts(), new SessionDefinedIntervals());
        $timeLineFrom   = $timeLineIntervalDetector->getTimeLineInterval($timeLineIntervalDetector::TIMELINE_FROM_KEY,true);
        $timeLineTo     =  $timeLineIntervalDetector->getTimeLineInterval($timeLineIntervalDetector::TIMELINE_UNTIL_KEY,true);



        $tlTransporterParts = new TimeLineTrasporterParts();
        $tlTransporterParts->setTimeLineFrom($timeLineFrom);
        $tlTransporterParts->setTimeLineUntil($timeLineTo);

        $transporterParts = $tlTransporterParts->getTransporterRecords();

        $timeLineGoings = new TimeLineGoings();
        $timeLineGoings->setTimeLineFrom($timeLineFrom);
        $timeLineGoings->setTimeLineUntil($timeLineTo);
        $timeLineGoings->setVehicleId($definedVehicleId);
//        dd($timeLineGoings,$transporterParts,$timeLineFrom, $timeLineTo);
        $goings     = $timeLineGoings->getTimeLineGoingsRecords();
//        dd($timeLineGoings, $goings);

        $tlTransporterPartsCollector = new TimelineTransportCollector();
        $tlTransporterPartsCollector->setTimeLineTransportQuery($transporterParts);

        $tlGoingsCollector = new TimelineGoingsCollector();
        $tlGoingsCollector->setTimeLineGoingsQuery($timeLineGoings);


        $timelineDriverCollector = new TimelineDriverCollector();

        $drivers   = $timelineDriverCollector->collection();

        $timelineVehicleCollector   = new TimelineVehicleCollector();

        $vehicles   = $timelineVehicleCollector->collection();

        $timelineMetaData = [
//            'timeLineFrom' => $timeLineIntervalDetector->getTimeLineInterval($timeLineIntervalDetector::TIMELINE_FROM_KEY,true, 'd.m.Y'),
//            'timeLineTo' =>$timeLineIntervalDetector->getTimeLineInterval($timeLineIntervalDetector::TIMELINE_UNTIL_KEY,true, 'd.m.Y'),,
            'vehicleSelectOptions' => $vehicleSelectOptions,
            'selectedVehicleId' => $sessionDefinedVehicle->getDefinedVehicleId(),
            'DateTime'  => [
                'from'  =>  $timeLineIntervalDetector->getTimeLineInterval($timeLineIntervalDetector::TIMELINE_FROM_KEY,true, 'd.m.Y'),
                'to'    => $timeLineIntervalDetector->getTimeLineInterval($timeLineIntervalDetector::TIMELINE_UNTIL_KEY,true, 'd.m.Y')
            ]
        ];
//


        $grouppedTimeline = $timelineDriverCollector->collectable()
            ->merge($timelineVehicleCollector->collectable())
            ->merge($tlGoingsCollector->collectable());
//        ->merge($tlTransporterPartsCollector->collectable());

        return $this->render('viewer',[
            'timelineMetaData' => $timelineMetaData,
            'transporterParts'=>$transporterParts,
            'goings'    => $goings,
            'drivers'   => $drivers,
            'vehicles'   => $vehicles,
            'timelineData'  => [
                'drivers'   => $timelineDriverCollector->mapToJson(),
                'vehicles'  => $timelineDriverCollector->mapToJson(),
                'goings'    => $tlGoingsCollector->mapToJson(),
                'groupped'  => $grouppedTimeline->toJson()
            ]
        ]);
    }

    protected function viewerRedirector(array $params)
    {
        $route = ['/transporter/viewer'];

        return $this->redirect(\yii\helpers\Url::toRoute(array_merge($route,$params)));
    }


}

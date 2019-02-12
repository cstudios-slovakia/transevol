<?php

namespace app\controllers;

use app\models\Drivers;
use app\models\Goings;
use app\models\TimelineDriver;
use app\models\TimelineVehicle;
use app\models\Transporter;
use app\models\TransporterParts;
use app\support\Timeline\Collectors\TimelineDriverCollector;
use app\support\Timeline\Collectors\TimelineVehicleCollector;
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

        $sessionVehicleId    = \Yii::$app->session->get('vehicleId');
        $sessionTimelineFrom    = \Yii::$app->session->get('timelineFrom');
        $sessionTimelineUntil    = \Yii::$app->session->get('timelineUntil');


        $timelineFrom  = $sessionTimelineFrom;
        $timelineUntil  = $sessionTimelineUntil;

        // TODO if session keys dont exists


        $transporterParts = TransporterParts::find()
            ->joinWith('transporter')
            ->joinWith([
                'places' => function (\yii\db\ActiveQuery $query) {
                    $query->joinWith('placeTypes');
                    $query->where(['placetype_name' => 'loading']);
                    $query->orWhere(['placetype_name' => 'unloading']);
                },
            ])
            ->with('placeTypes')
            ->with('places')
//            ->where(new Expression('SELECT place_types.id FROM place_types WHERE placetype_name = "loading" OR placetype_name= "unloading"'))

            ->andWhere(['between','event_time', $timelineFrom .' 00:00:00', $timelineUntil.' 23:59:59'])


//            ->groupBy(['transporter.id'])
            ->orderBy('event_time')
            ->all();


//        dd($transporterParts,$sessionVehicleId,$sessionTimelineFrom,$sessionTimelineUntil);


        $intervalFormatter = new IntervalFormatter();
//        $intervalFormatter->setProcessFormat('d.m.Y');

        $intervalDetector = new DateTimeIntervalDetector();
        $intervalDetector->setFormatter($intervalFormatter);

        $timelineFrom = $intervalDetector->getTimelineFrom();
        $timelineUntil = $intervalDetector->getTimelineUntil();



        $intervalParts = new IntervalParts();

//        if(empty($timelineFrom)){
//            $timelineFrom = $intervalFormatter->formatter($intervalParts->getStart());
//        }
//
//        if(empty($timelineUntil)){
//            $timelineUntil = $intervalFormatter->formatter($intervalParts->getEnd());
//
//        }



        $vehicleSelectOptions = VehicleRelationAssistance::ownedVehicles();

        $selectedVehicleId = (int) $sessionVehicleId;

        $goings     = Goings::find()
            ->joinWith([
                'vehicles'  => function (\yii\db\ActiveQuery $query) use ($selectedVehicleId){
                    $query->andWhere(['vehicles.id' => $selectedVehicleId]);
                 }
            ])
        ->all();



//
//
//        $requestTimelineFrom = \Yii::$app->request->get(DateTimeIntervalDetector::TIMELINE_FROM, null);
//        $requestTimelineUntil = \Yii::$app->request->get(DateTimeIntervalDetector::TIMELINE_UNTIL, null);
//        $requestVehicleId = \Yii::$app->request->get('vehicleId', null);

//
//        if (! $requestTimelineFrom || !$requestTimelineUntil || !$requestVehicleId ){
//            $redirectIntervalFormatter = new IntervalFormatter();
//            $redirectIntervalFormatter->setLocaleFormat('Y-m-d');
//            $redirectIntervalFormatter->setProcessFormat('d.m.Y');
//
//            $redirectIntervalDetector = new DateTimeIntervalDetector();
//            $redirectIntervalDetector->setFormatter($redirectIntervalFormatter);
////dd($redirectIntervalDetector);
//
//            $redirectIntervalParts = new IntervalParts();
//
//            $timelineFrom = $redirectIntervalFormatter->formatter($redirectIntervalParts->getStart());
//            $timelineUntil = $redirectIntervalFormatter->formatter($redirectIntervalParts->getEnd());
//
//
//            $timelineFrom = !$requestTimelineFrom ? $timelineFrom : $requestTimelineFrom;
//            $timelineUntil = !$requestTimelineUntil ? $timelineUntil : $requestTimelineUntil;
//
//            $requestVehicleId = $selectedVehicleId;
//
//            if ($requestVehicleId < 1){
//
//                $requestVehicleId = each($vehicleSelectOptions)['key'];
//                \Yii::$app->session->set('vehicleId', $requestVehicleId);
//            }
//
//            return $this->viewerRedirector([
//                'tfrom' => $timelineFrom,
//                'tuntil'=> $timelineUntil,
//                'vehicleId' => $requestVehicleId
//            ]);
//        }

//
//        if ($requestVehicleId != $selectedVehicleId){
//
//            return $this->viewerRedirector([
//                'tfrom' => $requestTimelineFrom,
//                'tuntil'=> $requestTimelineUntil,
//                'vehicleId' => $selectedVehicleId
//            ]);
//        }


//        $vehicles = TimelineVehicle::find()->joinWith([
//            'vehicle' => function($query) use ($selectedVehicleId){
//                $query->andWhere(['vehicles.id' => $selectedVehicleId]);
//            }
//        ])->all();

        $timelineDriverCollector = new TimelineDriverCollector();

        $drivers   = $timelineDriverCollector->collection();

        $timelineVehicleCollector   = new TimelineVehicleCollector();

        $vehicles   = $timelineVehicleCollector->collection();

        $timelineMetaData = [
            'timelineFrom' => $timelineFrom,
            'timelineUntil' => $timelineUntil,
            'vehicleSelectOptions' => $vehicleSelectOptions,
            'selectedVehicleId' => $sessionVehicleId
        ];
//
//        $x = $timelineDriverCollector->mapToJson();
//
//        dd($x);


        $grouppedTimeline = $timelineDriverCollector->collectable()->merge($timelineVehicleCollector->collectable());

        return $this->render('viewer',[
            'timelineMetaData' => $timelineMetaData,
            'transporterParts'=>$transporterParts,
            'goings'    => $goings,
            'drivers'   => $drivers,
            'vehicles'   => $vehicles,
            'timelineData'  => [
                'drivers'   => $timelineDriverCollector->mapToJson(),
                'vehicles'  => $timelineDriverCollector->mapToJson(),
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

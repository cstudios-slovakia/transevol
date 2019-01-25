<?php

namespace app\controllers;

use app\models\Transporter;
use app\models\TransporterParts;
use app\support\Transporter\DateTimeIntervalDetector;
use app\support\Transporter\IntervalFormatter;
use app\support\Transporter\IntervalParts;
use app\support\Vehicles\Relations\VehicleRelationAssistance;
use Carbon\Carbon;
use yii\db\Expression;
use yii\db\Query;

class TransporterController extends \yii\web\Controller
{
    public function actionViewer()
    {

        $intervalFormatter = new IntervalFormatter();
//        $intervalFormatter->setProcessFormat('d.m.Y');

        $intervalDetector = new DateTimeIntervalDetector();
        $intervalDetector->setFormatter($intervalFormatter);

        $timelineFrom = $intervalDetector->getTimelineFrom();
        $timelineUntil = $intervalDetector->getTimelineUntil();



        $intervalParts = new IntervalParts();

        if(empty($timelineFrom)){
            $timelineFrom = $intervalFormatter->formatter($intervalParts->getStart());
        }

        if(empty($timelineUntil)){
            $timelineUntil = $intervalFormatter->formatter($intervalParts->getEnd());

        }



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


        $vehicleSelectOptions = VehicleRelationAssistance::ownedVehicles();


//
//

        $timelineMetaData = [
            'timelineFrom' => $timelineFrom,
            'timelineUntil' => $timelineUntil,
            'vehicleSelectOptions' => $vehicleSelectOptions
        ];


        return $this->render('viewer',['timelineMetaData' => $timelineMetaData,'transporterParts'=>$transporterParts]);
    }

}

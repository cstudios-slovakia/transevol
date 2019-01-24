<?php

namespace app\controllers;

use app\models\Transporter;
use Carbon\Carbon;

class TransporterController extends \yii\web\Controller
{
    public function actionViewer()
    {
        $today = Carbon::now()->format('d.m.Y');


        $timelineFrom = \Yii::$app->request->get('tfrom',$today);
        $timelineTo = \Yii::$app->request->get('tto',$today);

        $transporterStack = Transporter::find()->with('transporterParts')->all();
//        dd($transporterStack);

        $timelineMetaData = [
            'timelineFrom' => $timelineFrom,
            'timelineTo' => $timelineTo,

        ];

        return $this->render('viewer',['timelineMetaData' => $timelineMetaData]);
    }

}

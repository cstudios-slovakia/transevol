<?php

namespace app\controllers\api\v1;

class VehicleDefiniatorController extends \yii\web\Controller
{
    const VEHICLE_ID_KEY = 'vehicleId';

    public function actionVehicle()
    {
        $session = \Yii::$app->session;

        $vehicleId = (int) \Yii::$app->request->post(self::VEHICLE_ID_KEY);

        $session->set(self::VEHICLE_ID_KEY, $vehicleId);

        return $session->get(self::VEHICLE_ID_KEY);
    }

}

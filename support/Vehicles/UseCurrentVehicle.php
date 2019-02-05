<?php

namespace app\support\Vehicles;

use app\models\Vehicles;
use app\support\Vehicles\Relations\VehicleRelationAssistance;
use Yii;
trait UseCurrentVehicle
{
    /** @var Vehicles */
    protected $vehicle;

    protected function checkVehicleSession() : bool
    {
        return Yii::$app->session->has($this->vehicleSessionKey());
    }

    protected function getVehicleIdSession() : int
    {
        if (! $this->checkVehicleSession()){
            $this->setDefaultVehicle();

        }

        $vehicleId = (int) Yii::$app->session->get($this->vehicleSessionKey());

        return $vehicleId;
    }

    protected function setDefaultVehicle() : self
    {
        $ownedVehicles = VehicleRelationAssistance::ownedVehicles();

        $firstOwnedVehicleId = (int) each($ownedVehicles)['key'];

        $this->defineVehicle($firstOwnedVehicleId);

        Yii::$app->session->set($this->vehicleSessionKey(),$this->vehicle->id);

        return $this;
    }

    protected function defineVehicle(int $id) : Vehicles
    {
        return $this->vehicle = Vehicles::findOne(['id' => $id]);
    }

    protected function vehicleSessionKey() : string
    {
        return 'vehicleId';
    }

    public function getVehicle() : Vehicles
    {
        if(! isset($this->vehicle)){
            $this->defineVehicle($this->getVehicleIdSession());
        }

        return $this->vehicle;
    }
}
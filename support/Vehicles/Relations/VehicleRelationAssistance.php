<?php

namespace app\support\Vehicles\Relations;

use app\models\EmissionClasses;
use app\models\VehicleTypes;

class VehicleRelationAssistance
{

    public static function vehicleTypesList() : array
    {
        $vehicleTypes = VehicleTypes::find()->all();

        return collect($vehicleTypes)->pluck('vehicle_type_name','id')->toArray();
    }


    public static function emissionClassesList() : array
    {
        $emissions = EmissionClasses::find()->all();

        return collect($emissions)->pluck('emission_name','id')->toArray();
    }


}
<?php

namespace app\support\Drivers\Relations;

use app\models\Drivers;

class DriverRelationAssistance
{
    public static function ownedDriversSelectOptions() : array
    {
        $drivers = Drivers::find()->all();

        return collect($drivers)->pluck('driver_name','id')->toArray();
    }
}
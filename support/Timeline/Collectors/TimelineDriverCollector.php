<?php

namespace app\support\Timeline\Collectors;

use app\models\TimelineDriver;
use app\support\Vehicles\UseCurrentVehicle;
use Carbon\Carbon;

class TimelineDriverCollector
{
    use UseCurrentVehicle;

    public function collection()
    {
        $drivers = TimelineDriver::find()
            ->joinWith([
                'vehicles' => function($query)  {
                    $query->andWhere(['vehicles.id' => $this->getVehicle()->id]);
                }
            ])
            ->with(['drivers'])
            ->all();

        return $drivers;
    }

    public function mapToJson()
    {
        $drivers = collect($this->collection())->map(function($timelineDriver){

            $recordUntil = Carbon::createFromFormat('Y-m-d H:i:s',$timelineDriver->driver_record_until);
            if ($recordUntil->year < 0){
                $recordUntil = Carbon::today()->timestamp * 1000;
            } else{
                $recordUntil = $recordUntil->timestamp * 1000;
            }

            return [
                $timelineDriver->drivers->driver_name,
                Carbon::createFromFormat('Y-m-d H:i:s',$timelineDriver->driver_record_from)->timestamp * 1000,
                $recordUntil,
            ];


        });

        return $drivers->toJson();
    }
}
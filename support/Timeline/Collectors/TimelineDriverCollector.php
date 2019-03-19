<?php

namespace app\support\Timeline\Collectors;

use app\models\TimelineDriver;
use app\support\Vehicles\UseCurrentVehicle;
use Carbon\Carbon;
use Illuminate\Support\Collection;

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

    public function collectable() : Collection
    {
        return $drivers = collect($this->collection())->map(function($timelineDriver){

            $recordUntil = Carbon::createFromFormat('Y-m-d H:i:s',$timelineDriver->driver_record_until);
            if ($recordUntil->year < 0){
                $recordUntil = Carbon::today();
            } else{
                $recordUntil = $recordUntil;
            }

            return [
                'id' => TimelineDriver::TIMELINE_ITEM_ID_PREDIX.$timelineDriver->id,
                'content' => $timelineDriver->drivers->driver_name,
                'className' => 'item--driver',
                'start' => Carbon::createFromFormat('Y-m-d H:i:s',$timelineDriver->driver_record_from)->format('c'),
                'end' => $recordUntil->format('c'),
                'group' => TimelineDriver::TIMELINE_ITEM_GROUP_NUMBER
            ];


        });
    }

    public function mapToJson()
    {
        $drivers = $this->collectable();

        return $drivers->toJson();
    }
}
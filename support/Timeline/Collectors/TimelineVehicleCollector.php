<?php

namespace app\support\Timeline\Collectors;

use app\models\TimelineDriver;
use app\models\TimelineVehicle;
use app\support\Vehicles\UseCurrentVehicle;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TimelineVehicleCollector
{
    use UseCurrentVehicle;

    public function collection()
    {
        $selectedVehicleId  = $this->getVehicle()->id;
        $vehicles = TimelineVehicle::find()->joinWith([
            'vehicle' => function($query) use ($selectedVehicleId){
                $query->andWhere(['vehicles.id' => $selectedVehicleId]);
            }
        ])->all();

        return $vehicles;
    }

    public function collectable() : Collection
    {
        return $collectable = collect($this->collection())->map(function($timelineVehicle){

            $recordUntil = Carbon::createFromFormat('Y-m-d H:i:s',$timelineVehicle->vehicle_record_until);
            if ($recordUntil->year < 0){
                $recordUntil = Carbon::today();
            } else{
                $recordUntil = $recordUntil;
            }

            return [
                'id' => TimelineVehicle::TIMELINE_ITEM_ID_PREDIX.$timelineVehicle->id,
                'content' => $timelineVehicle->vehicle->ecv,

                'start' => Carbon::createFromFormat('Y-m-d H:i:s',$timelineVehicle->vehicle_record_from)->format('c'),
                'end' => $recordUntil->format('c'),
                'group' => TimelineVehicle::TIMELINE_ITEM_GROUP_NUMBER,
                'className' => 'item--vehicle'
            ];


        });
    }

    public function mapToJson()
    {
        $collectable = $this->collectable();

        return $collectable->toJson();
    }
}
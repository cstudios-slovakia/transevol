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
                'id' => $timelineVehicle->id,
                'content' => $timelineVehicle->vehicle->ecv,
//                Carbon::createFromFormat('Y-m-d H:i:s',$timelineDriver->driver_record_from)->timestamp * 1000,
//                date('d-m-Y G:H', strtotime($phpDateVariable));
                'start' => Carbon::createFromFormat('Y-m-d H:i:s',$timelineVehicle->vehicle_record_from)->format('c'),
                'end' => $recordUntil->format('c'),
                'group' => 2
            ];


        });
    }

    public function mapToJson()
    {
        $collectable = $this->collectable();

        return $collectable->toJson();
    }
}
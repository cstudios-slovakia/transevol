<?php

namespace app\support\Timeline\Collectors;

use app\models\TimelineDriver;
use app\models\TimelineVehicle;
use app\support\Timeline\Filter\TimeLineGoings;
use app\support\Vehicles\UseCurrentVehicle;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TimelineGoingsCollector
{

    /** @var TimeLineGoings */
    protected $timeLineGoings;

    public function collection()
    {
        return $this->timeLineGoings->getTimeLineGoingsRecords();
    }

    public function collectable() : Collection
    {
        return $collectable = collect($this->collection())->map(function($record){

//            $recordUntil = Carbon::createFromFormat('Y-m-d H:i:s',$timelineVehicle->vehicle_record_until);
//            if ($recordUntil->year < 0){
//                $recordUntil = Carbon::today();
//            } else{
//                $recordUntil = $recordUntil;
//            }

            return [
                'id' => $record->id,
                'content' => "$record->id",

                'start' => Carbon::createFromFormat('Y-m-d H:i:s',$record->going_from)->format('c'),
                'end' => Carbon::createFromFormat('Y-m-d H:i:s',$record->going_until)->format('c'),
                'group' => 3
            ];


        });
    }

    public function mapToJson()
    {
        $collectable = $this->collectable();

        return $collectable->toJson();
    }

    /**
     * @param mixed $timeLineGoingsQuery
     */
    public function setTimeLineGoingsQuery($timeLineGoingsQuery)
    {
        $this->timeLineGoings= $timeLineGoingsQuery;
    }


}
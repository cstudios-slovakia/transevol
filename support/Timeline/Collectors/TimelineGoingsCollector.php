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

            $start  = Carbon::createFromFormat('Y-m-d H:i:s',$record->going_from);
            $end    = Carbon::createFromFormat('Y-m-d H:i:s',$record->going_until);

            $diffInHour     = $start->diff($end);
            $tlItemContent = "<span>$record->id</span> ".\Yii::t('timeline/item/goings','Výkon')." ". $diffInHour->format('%h:%i')." h";

            return [
                'id'        => $record->id,
                'content'   => $tlItemContent,
                'start'     => $start->format('c'),
                'end'       => $end->format('c'),
                'group'     => 3,
                'className' => 'item--going'
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
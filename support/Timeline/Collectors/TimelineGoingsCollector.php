<?php

namespace app\support\Timeline\Collectors;

use app\models\Goings;
use app\models\TimelineDriver;
use app\models\TimelineVehicle;
use app\support\Timeline\Filter\TimeLineGoings;
use app\support\Vehicles\UseCurrentVehicle;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use yii\helpers\Url;

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
       
            $diffInHour     = $start->diffInRealHours($end);
            $diffAddedMinutes   = $start->diff($end)->m;
            $tlItemContent = \Yii::t('timeline/item/goings','Výkon')." ". $diffInHour." h";

            return [
                'id'        => Goings::TIMELINE_ITEM_ID_PREDIX.$record->id,
                'content'   => $tlItemContent,
                'start'     => $start->format('c'),
                'end'       => $end->format('c'),
                'group'     => Goings::TIMELINE_ITEM_GROUP_NUMBER,
                'className' => 'item--going',
                'href'       => Url::toRoute(['api/v1/goings/update','id' => $record->id])
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
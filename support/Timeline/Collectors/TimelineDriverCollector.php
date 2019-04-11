<?php

namespace app\support\Timeline\Collectors;

use app\models\TimelineDriver;
use app\support\Vehicles\UseCurrentVehicle;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use yii\helpers\Url;

class TimelineDriverCollector
{
    use UseCurrentVehicle;

    protected $timeLineViewportStartsAt;
    protected $timeLineViewportEndsAt;

    public function collection()
    {
        $drivers = TimelineDriver::find()
            ->joinWith([
                'vehicles' => function($query)  {
                    $query->andWhere(['vehicles.id' => $this->getVehicle()->id]);
                }
            ])
            ->with(['drivers'])
            ->where(['between','driver_record_from',$this->timeLineViewportStartsAt,$this->timeLineViewportEndsAt])
            ->orWhere(['between','driver_record_until',$this->timeLineViewportStartsAt,$this->timeLineViewportEndsAt])
            ->all();

        return $drivers;
    }

    public function collectable() : Collection
    {
        return $drivers = collect($this->collection())->map(function($timelineDriver){

            $recordUntil = $timelineDriver->driver_record_until;

            $item =  [
                'id' => TimelineDriver::TIMELINE_ITEM_ID_PREDIX.$timelineDriver->id,
                'content' => $timelineDriver->drivers->driver_name,
                'className' => 'item--driver',
                'start' => Carbon::createFromFormat('Y-m-d H:i:s',$timelineDriver->driver_record_from)->format('c'),
                'group' => TimelineDriver::TIMELINE_ITEM_GROUP_NUMBER,
                'href'       => Url::toRoute(['api/v1/timeline-driver/update','id' => $timelineDriver->id])
            ];

            if ($recordUntil){
                $endsOn = ['end' => Carbon::createFromFormat('Y-m-d H:i:s',$recordUntil)];
                $item = array_merge($item, $endsOn);

            }


            return $item;
        });
    }

    public function mapToJson()
    {
        $drivers = $this->collectable();

        return $drivers->toJson();
    }

    /**
     * @param mixed $timeLineViewportStartsAt
     */
    public function setTimeLineViewportStartsAt($timeLineViewportStartsAt)
    {
        $this->timeLineViewportStartsAt = $timeLineViewportStartsAt;
    }

    /**
     * @param mixed $timeLineViewportEndsAt
     */
    public function setTimeLineViewportEndsAt($timeLineViewportEndsAt)
    {
        $this->timeLineViewportEndsAt = $timeLineViewportEndsAt;
    }
}
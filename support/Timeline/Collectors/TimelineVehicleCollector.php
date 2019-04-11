<?php

namespace app\support\Timeline\Collectors;

use app\models\TimelineDriver;
use app\models\TimelineVehicle;
use app\support\Vehicles\UseCurrentVehicle;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use yii\helpers\Url;

class TimelineVehicleCollector
{
    use UseCurrentVehicle;

    protected $timeLineViewportStartsAt;
    protected $timeLineViewportEndsAt;

    public function collection()
    {
        $selectedVehicleId  = $this->getVehicle()->id;
        $vehicles = TimelineVehicle::find()->joinWith([
            'vehicle' => function($query) use ($selectedVehicleId){
                $query->andWhere(['vehicles.id' => $selectedVehicleId]);
            }
        ])
            ->where(['between','vehicle_record_from',$this->timeLineViewportStartsAt,$this->timeLineViewportEndsAt])
            ->orWhere(['between','vehicle_record_until',$this->timeLineViewportStartsAt,$this->timeLineViewportEndsAt])

            ->all();

        return $vehicles;
    }

    public function collectable() : Collection
    {
        return $collectable = collect($this->collection())->map(function($timelineVehicle){

            $item   = [
                'id' => TimelineVehicle::TIMELINE_ITEM_ID_PREDIX.$timelineVehicle->id,
                'content' => $timelineVehicle->vehicle->ecv,
                'start' => Carbon::createFromFormat('Y-m-d H:i:s',$timelineVehicle->vehicle_record_from)->format('c'),
                'group' => TimelineVehicle::TIMELINE_ITEM_GROUP_NUMBER,
                'className' => 'item--vehicle',
                'href'       => Url::toRoute(['api/v1/timeline-vehicle/update','id' => $timelineVehicle->id])

            ];

            // sometimes we does not have defined end datetime
            $recordUntil = $timelineVehicle->vehicle_record_until;

            if($recordUntil){
                $endsOn     = [
                    'end'   => $recordUntil = Carbon::createFromFormat('Y-m-d H:i:s', $recordUntil)
                ];

                // item 'end' should be defined only with correct datetime
                $item = array_merge($item, $endsOn);
            }

            return $item;

        });
    }

    public function mapToJson()
    {
        $collectable = $this->collectable();

        return $collectable->toJson();
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
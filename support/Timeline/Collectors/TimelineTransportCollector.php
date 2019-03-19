<?php

namespace app\support\Timeline\Collectors;

use app\models\TimelineDriver;
use app\models\TimelineVehicle;
use app\models\Transporter;
use app\models\TransporterParts;
use app\support\Timeline\Filter\TimeLineGoings;
use app\support\Vehicles\UseCurrentVehicle;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use yii\helpers\Url;
use yii\log\Logger;

class TimelineTransportCollector
{

    /** @var TransporterParts */
    protected $timeLineTransport;

    public function collection()
    {
        return $this->timeLineTransport;
    }

    public function collectable() : Collection
    {
        $dataset  = collect($this->collection())
            ->groupBy(function($part){

                return $part->transporter->id;
            })
            ->pipe(function(Collection $collection){
                return $collection->map(function ($collectedById){
                    return $collectedById->keyBy(function ($parts){
                        return $parts->placeTypes->placetype_name;
                    });
                });
            })
            ->transform(function (Collection $partsCollection, $key){
                /** @var TransporterParts $loading */
                /** @var TransporterParts $unloading */
                $loading = $partsCollection->has('loading') ? $partsCollection->get('loading') : null;
                $unLoading = $partsCollection->has('unloading') ? $partsCollection->get('unloading') : null;

                $elementIdentification = [
                    'id'    => Transporter::TIMELINE_ITEM_ID_PREDIX.$key,
                    'content'   => $this->buildContentPartial($loading).
                        ' - ' .
                        $this->buildContentPartial($unLoading),
                    'group' => Transporter::TIMELINE_ITEM_GROUP_NUMBER,
                    'className'     => 'item--transporter',
                    'href'       => Url::toRoute(['api/v1/transporter/view','id' => $key])
                ];

                if ( ! is_null($loading)){
                    $elementIdentification = array_merge($elementIdentification, [
                        'start'     => Carbon::createFromFormat('Y-m-d H:i:s',$loading->event_time)->format('c')
                    ]);
                }


                if ( ! is_null($unLoading)){
                    $elementIdentification = array_merge($elementIdentification, [
                        'end'        =>  Carbon::createFromFormat('Y-m-d H:i:s',$unLoading->event_time)->format('c')
                    ]);
                }

                return $elementIdentification;


            })
            ->filter(function ($elementData){

                if (array_key_exists('start', $elementData)){
                    return $elementData;
                }
            });

        return $dataset;

    }

    protected function buildContentPartial($model)
    {
        $default ='[undefined]';
        if (is_null($model)){
            return $default;
        }

        if (is_null($model->places))
            return $default;

        return $model->places->place_name;
    }

    public function mapToJson()
    {
        $collectable = $this->collectable();

        return $collectable->toJson();
    }


    public function setTimeLineTransportQuery($transporterParts)
    {
        $this->timeLineTransport= $transporterParts;
    }


}
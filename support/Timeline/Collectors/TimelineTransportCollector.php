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
        $collectable = collect($this->collection())->map(function ($transporterPart) {

            $placeType = $transporterPart->placeTypes->placetype_name;
            if ($placeType === 'loading' || $placeType === 'unloading'){
                return [
                    'id'    => $transporterPart->transporter[0]->id,
                    'content'   => $transporterPart->places->place_name,
                    'type'  => $placeType,
                    'event_time' => $transporterPart->event_time
                ];
            }

        });
        $x = $collectable->groupBy('id')->map(function($transports){
            $load = $transports->filter(function ($transportPart){
                if ($transportPart['type'] === 'loading'){
                    return $transportPart;
                }
            })->first();

            $unload = $transports->filter(function ($transportPart){
                if ($transportPart['type'] === 'unloading'){
                    return $transportPart;
                }
            })->first();

            return [
                'id'    => $load['id'],
                'content'   => $load['content'] .' - '. $unload['content'],
                'start' => $load['event_time'],
                'end'   => $unload['event_time'],
                'group' => 4
            ];
        });

        return $x;
        dd($x);
        return $collectable = collect($this->collection())->groupBy(function($transporterPart){
            dd($transporterPart);
           return $transporterPart->transporter[0]->id;
        })->map(function($record){
//            dd($record);
//            $recordUntil = Carbon::createFromFormat('Y-m-d H:i:s',$timelineVehicle->vehicle_record_until);
//            if ($recordUntil->year < 0){
//                $recordUntil = Carbon::today();
//            } else{
//                $recordUntil = $recordUntil;
//            }

            return [
                'id' => $record->id,
                'content' => "$record->id",

                'start' => Carbon::createFromFormat('Y-m-d H:i:s',$record->event_time)->format('c'),
                'end' => Carbon::createFromFormat('Y-m-d H:i:s',$record->event_time)->format('c'),
                'group' => 3
            ];


        });
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
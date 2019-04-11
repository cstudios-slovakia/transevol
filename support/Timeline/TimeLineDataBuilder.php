<?php namespace app\support\Timeline;

use app\support\Vehicles\Relations\VehicleRelationAssistance;
use app\support\Transporter\IntervalParts;
use app\support\Timeline\SessionDefinedVehicle;
use app\support\Timeline\Intervals\SessionDefinedIntervals;
use Carbon\Carbon;
use app\support\Timeline\Filter\TimeLineTrasporterParts;
use app\support\Timeline\Filter\TimeLineGoings;
use app\models\TimelineVehicle;
use app\support\Timeline\Collectors\TimelineTransportCollector;
use app\support\Timeline\Collectors\TimelineGoingsCollector;
use app\support\Timeline\Collectors\TimelineDriverCollector;
use app\support\Timeline\Collectors\TimelineVehicleCollector;

class TimeLineDataBuilder
{
    public function renderableData() : array
    {
        // collect every owned vehicles, used in time line
        $vehicleSelectOptions = VehicleRelationAssistance::ownedVehicles();

        // session must have defined vehicleID
        $sessionDefinedVehicle  = new SessionDefinedVehicle();

        // we check vehicleId in first time too,
        // first vehicle should be used
        $definedVehicleId = array_first(array_keys($vehicleSelectOptions));

        if ( ! $sessionDefinedVehicle->getDefinedVehicleId()){
            $sessionDefinedVehicle->defineVehicleId($definedVehicleId);
        }
//        dd( $sessionDefinedVehicle->getDefinedVehicleId());

        // for timeline define start and end date/datetime
        // if session does not contains timeline interval data, last 2 days should be used
        $timeLineIntervalDetector = new TimeLineIntervalBuilder(new IntervalParts(), new SessionDefinedIntervals());
        $timeLineTo     =  $timeLineIntervalDetector->getTimeLineInterval($timeLineIntervalDetector::TIMELINE_UNTIL_KEY,true);
        $timeLineFrom   = $timeLineIntervalDetector->getTimeLineInterval($timeLineIntervalDetector::TIMELINE_FROM_KEY,true);
//        $timeLineFrom   = $timeLineIntervalDetector->getViewportEndPoints($timeLineIntervalDetector::NODE_DEFINITIONS[0],'Y-m-d');
//        $timeLineTo     =  $timeLineIntervalDetector->getViewportEndPoints($timeLineIntervalDetector::NODE_DEFINITIONS[1],'Y-m-d');

        $calculationIntervalDetector = new CalculationIntervalBuilder(new IntervalParts(), new SessionDefinedIntervals());
        $calculationFrom    = $calculationIntervalDetector->getTimeLineInterval(CalculationIntervalBuilder::TIMELINE_FROM_KEY, false, 'Y-m-d H:i');
        $calculationUntil    = $calculationIntervalDetector->getTimeLineInterval(CalculationIntervalBuilder::TIMELINE_UNTIL_KEY, false, 'Y-m-d H:i');

        $timeLineNodes = [
            'start' => $timeLineIntervalDetector->getViewportEndPoints($timeLineIntervalDetector::NODE_DEFINITIONS[0],'c'),
            'end'   => $timeLineIntervalDetector->getViewportEndPoints($timeLineIntervalDetector::NODE_DEFINITIONS[1],'c'),
//            'start' => Carbon::createFromFormat('Y-m-d', $timeLineFrom)->subDay()->format('c'),
//            'end'   => Carbon::createFromFormat('Y-m-d', $timeLineTo)->addDay()->format('c'),
        ];

        $tlTransporterParts = new TimeLineTrasporterParts();
        $tlTransporterParts->setTimeLineFrom($timeLineFrom);
        $tlTransporterParts->setTimeLineUntil($timeLineTo);

        $transporterParts = $tlTransporterParts->getTransporterRecords();

        $timeLineGoings = new TimeLineGoings();
        $timeLineGoings->setTimeLineFrom($timeLineFrom);
        $timeLineGoings->setTimeLineUntil($timeLineTo);
        $timeLineGoings->setVehicleId($definedVehicleId);
//        dd($timeLineGoings,$transporterParts,$timeLineFrom, $timeLineTo);
        $goings     = $timeLineGoings->getTimeLineGoingsRecords();
//        dd($timeLineGoings, $goings);

        $tlTransporterPartsCollector = new TimelineTransportCollector();
        $tlTransporterPartsCollector->setTimeLineTransportQuery($transporterParts);

        $tlGoingsCollector = new TimelineGoingsCollector();
        $tlGoingsCollector->setTimeLineGoingsQuery($timeLineGoings);


        $timelineDriverCollector = new TimelineDriverCollector();

        $drivers   = $timelineDriverCollector->collection();

        $timelineVehicleCollector   = new TimelineVehicleCollector();

        $vehicles   = $timelineVehicleCollector->collection();

        $timelineMetaData = [
            'vehicleSelectOptions' => $vehicleSelectOptions,
            'selectedVehicleId' => $sessionDefinedVehicle->getDefinedVehicleId(),
            'DateTime'  => [
                'from'  =>  $timeLineIntervalDetector->getTimeLineInterval($timeLineIntervalDetector::TIMELINE_FROM_KEY,true, 'd.m.Y'),
                'to'    => $timeLineIntervalDetector->getTimeLineInterval($timeLineIntervalDetector::TIMELINE_UNTIL_KEY,true, 'd.m.Y')
            ],
            'Calculation'   => [
                'interval'  => [
                    'from'  => $calculationFrom,
                    'until' => $calculationUntil
                ]
            ],
            'timeLineNodes' => $timeLineNodes
        ];


        $grouppedTimeline = $timelineDriverCollector->collectable()
            ->merge($timelineVehicleCollector->collectable())
            ->merge($tlGoingsCollector->collectable())
            ->merge($tlTransporterPartsCollector->collectable());

        $timeLineSection = [
            'id'            => 'section',
            'content'       => '',
            'start'         => $calculationFrom,
            'end'           => $calculationUntil,
            'type'          => 'background',
        ];
//        dd($timeLineSection);

        // calculation needs selection, selection is an interval defined section
        // section should be returned as an item, so push it into the group
        $grouppedTimeline = $grouppedTimeline->push($timeLineSection);

        return [
            'timelineMetaData' => $timelineMetaData,
            'transporterParts'=>$transporterParts,
            'goings'    => $goings,
            'drivers'   => $drivers,
            'vehicles'   => $vehicles,
            'timelineData'  => [
                'drivers'   => $timelineDriverCollector->mapToJson(),
                'vehicles'  => $timelineDriverCollector->mapToJson(),
                'goings'    => $tlGoingsCollector->mapToJson(),
                'groupped'  => $grouppedTimeline->toJson()
            ]
        ];
    }
}
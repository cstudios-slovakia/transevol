<?php namespace app\models\Calculations\TimeLine;


use app\models\TimelineVehicle;
use app\support\Timeline\Units\TimeLineElementContract;

class VehicleTimeLineElement extends TimelineVehicle implements TimeLineElementContract
{
    /** @var string */
    public $position_status;

    /** @var integer */
    public $interval_minutes;

    /** @var string */
    public $type_shortly;


    public function rules()
    {
        return [
            [['vehicle_record_from', 'vehicle_record_until', 'vehicle_id','position_status','interval_minutes','companies_id','id','type_shortly'], 'safe']
        ];
    }

    public function startAttribute() : string
    {
        return $this->vehicle_record_from;
    }

    public function endAttribute() : string
    {
        return $this->vehicle_record_until;
    }
}
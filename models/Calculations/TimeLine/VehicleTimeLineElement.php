<?php namespace app\models\Calculations\TimeLine;


use app\models\TimelineVehicle;

class VehicleTimeLineElement extends TimelineVehicle
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
}
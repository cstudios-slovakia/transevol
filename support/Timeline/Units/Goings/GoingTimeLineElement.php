<?php namespace app\support\Timeline\Units\Goings;

use app\models\Goings;
use app\support\Timeline\Intervals\IntervalEndpointsFinder;
use app\support\Timeline\Units\TimeLineElementContract;
use Carbon\Carbon;

class GoingTimeLineElement extends Goings implements TimeLineElementContract
{
    use IntervalEndpointsFinder;

    /** @var string */
    public $position_status;

    /** @var integer */
    public $interval_minutes;



    public function rules()
    {
        return [
            [['going_from', 'going_until'], 'required'],
            [['going_from', 'going_until', 'position_status','interval_minutes','companies_id','id'], 'safe']
        ];
    }


    public function startAttribute() : string
    {
        return $this->going_from;
    }

    public function endAttribute() : string
    {
        return $this->going_until;
    }

    public function carbonized(string $methodName) : ?Carbon
    {
        if (method_exists($this, $methodName)) {
            return Carbon::createFromFormat('Y-m-d H:i:s',$this->{$methodName}());
        }

        return null;
    }
}
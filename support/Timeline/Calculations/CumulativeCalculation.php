<?php namespace app\support\Timeline\Calculations;

use Carbon\CarbonPeriod;

class CumulativeCalculation
{
    /** @var CarbonPeriod */
    public $period;

    public $cost;

    public $result;

    public static function make($period, $cost) : self
    {
        $calculation = new self();

        $calculation->period = $period;
        $calculation->cost = $cost;

        return $calculation;
    }

    public function calculate()
    {
        $cost = $this->cost;
        foreach ($this->period as $date){

            $this->result[$date->format('Y-m-d H:i')]   = $cost;

            $cost+= $this->cost;
        }

        return collect($this->result);
    }
}
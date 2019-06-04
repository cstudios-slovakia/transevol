<?php namespace app\support\Timeline\Intervals;

use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;

class HourlyTicker extends IntervalTimeUnitTicker
{

    public function periods() : CarbonPeriod
    {
        return CarbonPeriod::create($this->intervalStarts, $this->intervalEnds)->setDateInterval(CarbonInterval::hour(1));
    }

}
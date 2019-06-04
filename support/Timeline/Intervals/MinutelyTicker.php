<?php namespace app\support\Timeline\Intervals;

use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;

class MinutelyTicker extends IntervalTimeUnitTicker
{

    public function periods() : CarbonPeriod
    {
        return CarbonPeriod::create($this->intervalStarts, $this->intervalEnds)->setDateInterval(CarbonInterval::minute(1));
    }


}
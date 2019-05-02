<?php namespace app\support\Timeline\Intervals;

use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;

class HourlyTicker extends DailyTicker
{
    protected function period()
    {
        return $this->period = CarbonPeriod::create($this->intervalStarts, $this->intervalEnds)
            ->setDateInterval(CarbonInterval::hour(1));
    }
}
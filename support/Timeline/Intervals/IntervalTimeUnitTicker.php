<?php namespace app\support\Timeline\Intervals;

use Carbon\Carbon;

class IntervalTimeUnitTicker implements TickerContract
{
    use IntervalHasDifference;

    public function __construct(Carbon $intervalStarts, Carbon $intervalEnds)
    {
        $this->setIntervalStarts($intervalStarts);
        $this->setIntervalEnds($intervalEnds);
    }
}
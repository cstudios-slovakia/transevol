<?php namespace app\support\Timeline\Intervals;

use Carbon\Carbon;

class IntervalBuilder extends BaseIntervalBuilder
{
    use IntervalEndpointsFinder;

    public function __construct(Carbon $intervalStarts, Carbon $intervalEnds)
    {
        $this->setIntervalStarts($intervalStarts);
        $this->setIntervalEnds($intervalEnds);
    }
}
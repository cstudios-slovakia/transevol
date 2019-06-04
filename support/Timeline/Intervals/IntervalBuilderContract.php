<?php namespace app\support\Timeline\Intervals;

use Carbon\Carbon;

interface IntervalBuilderContract
{
    public function getIntervalStarts(): Carbon;
    public function setIntervalStarts(Carbon $intervalStarts);
    public function getIntervalEnds(): Carbon;
    public function setIntervalEnds(Carbon $intervalEnds);
}
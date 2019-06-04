<?php namespace app\support\Timeline\Intervals;

use Carbon\Carbon;
use Carbon\CarbonInterval;

trait IntervalHasDifference
{
    /** @var Carbon */
    protected $intervalStarts;

    /** @var Carbon */
    protected $intervalEnds;

    public function intervalDifference() : CarbonInterval
    {
        return $this->intervalStarts->diffAsCarbonInterval($this->intervalEnds);
    }

    /**
     * @return Carbon
     */
    public function getIntervalStarts(): Carbon
    {
        return $this->intervalStarts;
    }

    /**
     * @param Carbon $intervalStarts
     */
    public function setIntervalStarts(Carbon $intervalStarts)
    {
        $this->intervalStarts = $intervalStarts;
    }

    /**
     * @return Carbon
     */
    public function getIntervalEnds(): Carbon
    {
        return $this->intervalEnds;
    }

    /**
     * @param Carbon $intervalEnds
     */
    public function setIntervalEnds(Carbon $intervalEnds)
    {
        $this->intervalEnds = $intervalEnds;
    }


}
<?php namespace app\support\Timeline\Intervals;

use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;

class IntervalTicker
{
    protected $intervalStarts;
    protected $intervalEnds;

    protected $ticksAmount;

    /**
     * @var CarbonPeriod
     */
    protected $period;

    public function __construct($intervalStarts, $intervalEnds)
    {
        $this->intervalStarts = $intervalStarts;
        $this->intervalEnds = $intervalEnds;
        $this->period();
        $this->ticksCounter();
    }

    protected function ticksCounter()
    {
        return $this->ticksAmount  = $this->period->count();
    }

    protected function period()
    {
        return $this->period = CarbonPeriod::create($this->intervalStarts, $this->intervalEnds)
            ->setDateInterval(CarbonInterval::day(1));
    }
}
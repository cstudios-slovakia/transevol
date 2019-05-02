<?php namespace app\support\Timeline\Intervals;

use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;

class DailyTicker
{
    protected $intervalStarts;
    protected $intervalEnds;

    protected $ticksAmount;

    /** @var CarbonPeriod */
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
            ->setDateInterval(CarbonInterval::hour(1));
    }

    /**
     * @return mixed
     */
    public function getIntervalStarts()
    {
        return $this->intervalStarts;
    }

    /**
     * @return mixed
     */
    public function getIntervalEnds()
    {
        return $this->intervalEnds;
    }

    /**
     * @return mixed
     */
    public function getTicksAmount()
    {
        return $this->ticksAmount;
    }

    /**
     * @return CarbonPeriod
     */
    public function getPeriod(): CarbonPeriod
    {
        return $this->period;
    }


}
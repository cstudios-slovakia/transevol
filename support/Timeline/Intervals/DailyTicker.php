<?php namespace app\support\Timeline\Intervals;

use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;

class DailyTicker
{
    use IntervalEndpointsFinder;

    protected $ticksAmount;

    /** @var CarbonPeriod */
    protected $period;

    protected $knots;

    public function __construct($intervalStarts, $intervalEnds)
    {
        $this->intervalStarts = $intervalStarts;
        $this->intervalEnds = $intervalEnds;
        $this->period();
        $this->ticksCounter();

        $this->knots = collect([]);

        $interval   = $this->intervalDifference();

        $x  =  CarbonPeriod::create($this->intervalStarts, $this->intervalEnds)
            ->setDateInterval($interval);
        $y  =  CarbonPeriod::create($this->intervalStarts, $this->intervalEnds)
            ->setDateInterval(CarbonInterval::hour(1));


        foreach ($x as $xDate){

            var_dump($xDate->format('Y-m-d H:i'));
        }

        foreach ($y as $yDate){
            var_dump($yDate->format('Y-m-d H:i'));
        }

        dd($interval,$x,$y);

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

    public function pushKnot($knot)
    {
        $this->knots->push($knot);
    }

    public function getKnotByIndex(int $index)
    {
        return $this->knots->get($index);
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
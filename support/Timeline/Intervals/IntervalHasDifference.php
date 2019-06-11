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


    /**
     * @param string $intervalPoint
     * @param string $format
     * @return string
     * @throws \Exception
     */
    public function formatted(string $intervalPoint, string $format = 'Y-m-d H:i') : string
    {

        if (! method_exists($this,$intervalPoint)){
            throw new \Exception('Method does not exists.');
        }
        // call function to return carbon formatted datetime
        $called = call_user_func([$this, $intervalPoint]);

        if (! $called instanceof Carbon && is_string($called)){
            $called     = Carbon::createFromFormat('Y-m-d H:i:s', $called);
        }

        return $called->format($format);
    }

}
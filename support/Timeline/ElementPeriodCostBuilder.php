<?php namespace app\support\Timeline;

use Carbon\Carbon;

class ElementPeriodCostBuilder
{
    const DEFAULT_PERIOD_TIME_UNIT = 'minute';

    /**
     * @var Carbon
     */
    protected $periodStarts;

    /** @var Carbon */
    protected $periodEnds;

    /** @var string */
    protected $periodDefinedIn;

    public function __construct(Carbon $periodStarts, Carbon $periodEnds, string $periodDefinedIn = self::DEFAULT_PERIOD_TIME_UNIT)
    {
        $this->setPeriodStarts($periodStarts);
        $this->setPeriodEnds($periodEnds);
        $this->setPeriodDefinedIn($periodDefinedIn);
    }

    /**
     * @param Carbon $periodStarts
     */
    public function setPeriodStarts(Carbon $periodStarts)
    {
        $this->periodStarts = $periodStarts;
    }

    /**
     * @param Carbon $periodEnds
     */
    public function setPeriodEnds(Carbon $periodEnds)
    {
        $this->periodEnds = $periodEnds;
    }

    /**
     * @param string $periodDefinedIn
     */
    public function setPeriodDefinedIn(string $periodDefinedIn)
    {
        $this->periodDefinedIn = $periodDefinedIn;
    }


}
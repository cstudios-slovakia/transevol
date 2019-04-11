<?php namespace app\support\Timeline\Intervals;

use app\support\Timeline\IntervalBuilderInterface;
use Carbon\Carbon;

/** DONT USE!!!! */
class IntervalParser implements IntervalBuilderInterface
{
    /** @var  Carbon */
    protected $from;

    /** @var  Carbon */
    protected $until;

    public function __construct(Carbon $from, Carbon $until)
    {
        $this->from = $from;
        $this->until = $until;
    }

    public function buildIntervalEnd() : self
    {
        // TODO: Implement buildIntervalEnd() method.
    }

    public function buildIntervalStart() : self
    {
        // TODO: Implement buildIntervalStart() method.
    }


}
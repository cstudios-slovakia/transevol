<?php namespace app\support\Timeline\Intervals;

use Carbon\Carbon;

abstract class BaseIntervalBuilder implements IntervalBuilderContract
{
    /** @var Carbon */
    protected $intervalStarts;

    /** @var Carbon */
    protected $intervalEnds;

}
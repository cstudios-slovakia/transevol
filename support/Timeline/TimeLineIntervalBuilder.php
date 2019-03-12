<?php namespace app\support\Timeline;

use app\support\Timeline\Intervals\SessionDefinedIntervals;
use app\support\Transporter\IntervalParts;
use Carbon\Carbon;

/**
 * Class TimeLineIntervalBuilder
 * @package app\support\Timeline
 */
class TimeLineIntervalBuilder
{
    /**
     *
     */
    const TIMELINE_FROM_KEY = 'timeLineFrom';
    /**
     *
     */
    const TIMELINE_UNTIL_KEY = 'timeLineUntil';

    /**
     * @var IntervalParts
     */
    protected $intervalParts;
    /**
     * @var SessionDefinedIntervals
     */
    protected $definedIntervals;

    /**
     * @var
     */
    protected $timeLineFrom;
    /**
     * @var
     */
    protected $timeLineUntil;

    /**
     * TimeLineIntervalBuilder constructor.
     * @param IntervalParts $intervalParts
     * @param SessionDefinedIntervals $sessionDefinedIntervals
     */
    public function __construct(IntervalParts $intervalParts, SessionDefinedIntervals $sessionDefinedIntervals)
    {
        $this->intervalParts    = $intervalParts;

        $this->definedIntervals = $sessionDefinedIntervals;

        $this->buildIntervals();
    }

    /**
     * @return TimeLineIntervalBuilder
     */
    protected function buildIntervals() : self
    {

        $this->buildIntervalStart();

        $this->buildIntervalEnd();

        return $this;
    }

    /**
     * @return TimeLineIntervalBuilder
     */
    protected function buildIntervalStart() : self
    {
        $from   = $this->definedIntervals->getIntervalNodeFrom();

        $this->timeLineFrom = $from ?: $this->intervalParts->getStart();

        $this->definedIntervals->setIntervalNode(self::TIMELINE_FROM_KEY, $this->timeLineFrom);

        return $this;
    }

    /**
     * @return TimeLineIntervalBuilder
     */
    protected function buildIntervalEnd() : self
    {
        $end = $this->definedIntervals->getIntervalNodeTo();

        $this->timeLineUntil = $end ?: $this->intervalParts->getEnd();

        $this->definedIntervals->setIntervalNode(self::TIMELINE_UNTIL_KEY, $this->timeLineUntil);

        return $this;
    }


    /**
     * @param string $timeLineKey
     * @param bool $withoutTime
     * @param string $format
     * @return string
     * @throws \Exception
     */
    public function getTimeLineInterval(string $timeLineKey, bool $withoutTime = true, string $format = 'Y-m-d') : string
    {

        if ( ! isset($this->{$timeLineKey})){
            throw new \Exception('TimeLineNode is not correctly configure.');
        }

        if ($withoutTime){
            return Carbon::createFromFormat('Y-m-d', $this->{$timeLineKey})->format($format);
        }

        return $this->{$timeLineKey};

    }
}
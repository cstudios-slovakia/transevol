<?php namespace app\support\Timeline;

use app\support\Timeline\Intervals\SessionDefinedIntervals;
use app\support\Transporter\IntervalParts;
use Carbon\Carbon;

/**
 * Class TimeLineIntervalBuilder
 * @package app\support\Timeline
 */
class TimeLineIntervalBuilder implements IntervalBuilderInterface
{
    /**
     *
     */
    const TIMELINE_FROM_KEY = 'timeLineFrom';
    /**
     *
     */
    const TIMELINE_UNTIL_KEY = 'timeLineUntil';

    const NODE_DEFINITIONS = ['startsAt','endsAt'];
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

    protected $timeLineViewportStartsAt;
    protected $timeLineViewportEndsAt;

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

    public function buildIntervalStart() : IntervalBuilderInterface
    {
        $from   = $this->definedIntervals->getIntervalNodeFrom();

        $this->timeLineFrom = $from ?: $this->intervalParts->getStart();

        $this->definedIntervals->setIntervalNode(self::TIMELINE_FROM_KEY, $this->timeLineFrom);

        return $this;
    }


    public function buildIntervalEnd() : IntervalBuilderInterface
    {
        $end = $this->definedIntervals->getIntervalNodeTo();

        $this->timeLineUntil = $end ?: $this->intervalParts->getEnd();

        $this->definedIntervals->setIntervalNode(self::TIMELINE_UNTIL_KEY, $this->timeLineUntil);

        return $this;
    }

    /**
     * Get timeline endpoint by its key.
     *
     * @param string $timeLineKey
     * @return Carbon
     * @throws \Exception
     */
    public function getTimeLineIntervalEndPoint(string $timeLineKey) : Carbon
    {
        if ( ! isset($this->{$timeLineKey})){
            throw new \Exception('TimeLineNode is not correctly configure.');
        }

        $timestamp = strtotime($this->{$timeLineKey});
        // sometimes we dont need time in timeline,
        // format to only date

        $timeLineInterval = Carbon::createFromTimestamp($timestamp);

        return $timeLineInterval;
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

        $timeLineInterval = $this->getTimeLineIntervalEndPoint($timeLineKey);

        if ($withoutTime){
            return $timeLineInterval->format($format);
        }

        if (!$withoutTime && $format === 'Y-m-d'){
            return $timeLineInterval->format($format . ' H:i');
        }

        return $timeLineInterval->format($format);
    }

    /**
     * Defines timeline viewport nodes, or node.
     *
     * @param string $nodeDefinition
     * @param string $format
     * @return array|string
     */
    public function getViewportEndPoints(string $nodeDefinition = '', string $format = 'Y-m-d')
    {
        $starts     = $this->getTimeLineIntervalEndPoint(self::TIMELINE_FROM_KEY)->subDay()->format($format);
        $ends       = $this->getTimeLineIntervalEndPoint(self::TIMELINE_UNTIL_KEY)->addDay()->format($format);

        $nodes      = [
            self::NODE_DEFINITIONS[0] => $starts,
            self::NODE_DEFINITIONS[1] => $ends,
        ];

        if ( ! empty($nodeDefinition) && in_array($nodeDefinition, self::NODE_DEFINITIONS, true)){
            return $nodes[$nodeDefinition];
        }

        return $nodes;
    }
}
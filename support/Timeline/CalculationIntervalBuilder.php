<?php namespace app\support\Timeline;

use app\support\Timeline\Intervals\SessionDefinedIntervals;
use app\support\Transporter\IntervalParts;
use Carbon\Carbon;

/**
 * Class TimeLineIntervalBuilder
 * @package app\support\Timeline
 */
class CalculationIntervalBuilder extends TimeLineIntervalBuilder
{
    /**
     *
     */
    const TIMELINE_FROM_KEY = 'calculationFrom';
    /**
     *
     */
    const TIMELINE_UNTIL_KEY = 'calculationUntil';

    /**
     * {@inheritdoc}
     */
    public function buildIntervalStart() : IntervalBuilderInterface
    {
        $from   = $this->definedIntervals->getIntervalNodeFrom(self::TIMELINE_FROM_KEY);

        $this->timeLineFrom = $from ?: $this->intervalParts->getStart();

        $this->definedIntervals->setIntervalNode(self::TIMELINE_FROM_KEY, $this->timeLineFrom);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function buildIntervalEnd() : IntervalBuilderInterface
    {
        $end = $this->definedIntervals->getIntervalNodeTo(self::TIMELINE_UNTIL_KEY);

        $this->timeLineUntil = $end ?: $this->intervalParts->getEnd();

        $this->definedIntervals->setIntervalNode(self::TIMELINE_UNTIL_KEY, $this->timeLineUntil);

        return $this;
    }
}
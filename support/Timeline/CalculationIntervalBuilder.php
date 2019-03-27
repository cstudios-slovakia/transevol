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
     * @var
     */
    protected $calculationFrom;
    /**
     * @var
     */
    protected $calculationUntil;
    /**
     * {@inheritdoc}
     */
    public function buildIntervalStart() : IntervalBuilderInterface
    {
        $from   = $this->definedIntervals->getIntervalNodeFrom(self::TIMELINE_FROM_KEY);

        $this->calculationFrom = $from ?: $this->intervalParts->getStart();

        $this->definedIntervals->setIntervalNode(self::TIMELINE_FROM_KEY, $this->calculationFrom);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function buildIntervalEnd() : IntervalBuilderInterface
    {
        $end = $this->definedIntervals->getIntervalNodeTo(self::TIMELINE_UNTIL_KEY);

        $this->calculationUntil = $end ?: $this->intervalParts->getEnd();

        $this->definedIntervals->setIntervalNode(self::TIMELINE_UNTIL_KEY, $this->calculationUntil);

        return $this;
    }
}
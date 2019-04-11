<?php namespace app\support\Timeline;

use app\support\Timeline\Intervals\SessionDefinedIntervals;
use app\support\Transporter\IntervalParts;
use Carbon\Carbon;
use yii\base\Exception;

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
     * Returns choosen interval in needed unit.
     *
     * @param string $timeUnit
     * @return mixed
     * @throws Exception
     */
    public function getIntervalIn(string $timeUnit = 'minutes')
    {
        $timeUnitMethod = ucfirst($timeUnit);

        if ( !isset($this->calculationFrom) || !isset($this->calculationUntil) ){
            throw new Exception('Interval edges are not correctly set.');
        }

        $method = 'intervalIn'.$timeUnitMethod;


        if (! method_exists($this,$method)){
            throw new Exception('Time Unit does not exists to calculate.');
        }
        return self::$method($this->calculationFrom,$this->calculationUntil);
    }

    /**
     * Calculates interval in minutes.
     *
     * @param $from
     * @param $until
     * @return int
     */
    public static function intervalInMinutes($from, $until) : int
    {
        $from       = Carbon::createFromFormat('Y-m-d H:i', $from);
        $until      = Carbon::createFromFormat('Y-m-d H:i', $until);

        $interval   = $from->diffAsCarbonInterval($until);

        return $interval->totalMinutes;
    }

    public static function intervalInHours($from, $until) : float
    {
        $from       = Carbon::createFromFormat('Y-m-d H:i', $from);
        $until      = Carbon::createFromFormat('Y-m-d H:i', $until);

        $interval   = $from->diffAsCarbonInterval($until);

        return $interval->totalHours;
    }

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
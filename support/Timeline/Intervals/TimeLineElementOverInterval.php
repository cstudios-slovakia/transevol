<?php namespace app\support\Timeline\Intervals;

use app\models\Calculations\TimeLine\VehicleTimeLineElement;
use app\support\Timeline\IntervalBuilderInterface;
use app\support\Timeline\Units\TimeLineElementContract;
use Carbon\Carbon;
use Carbon\CarbonInterval;

class TimeLineElementOverInterval
{
    const POSITION_BEGIN = 'beginners';
    const POSITION_IN = 'inners';
    const POSITION_END = 'enders';
    const POSITION_THROUGH = 'throughers';

    /**
     * @var TimeLineElementContract
     */
    protected $element;

    /** @var  IntervalBuilderContract */
    protected $interval;

    /** @var CarbonInterval */
    protected $overElementInterval;

    /** @var IntervalTickersBuilder */
    protected $elementTicker;

    public function __construct(IntervalBuilderContract $intervalBuilder, TimeLineElementContract $element)
    {
        $this->interval     = $intervalBuilder;
        $this->element      = $element;
//        dd($this);
        $this->makeElementsPosition($this->element->position_status);
    }


    public function makeElementsPosition(string $elementPosition)
    {
        switch ($elementPosition){
            case self::POSITION_BEGIN:
                $overElementInterval    = new OverElementInterval(self::carbonize($this->element->startAttribute()), $this->interval->getIntervalEnds());
                break;

            case self::POSITION_IN:
                $overElementInterval    = new OverElementInterval(self::carbonize($this->element->startAttribute()),self::carbonize($this->element->endAttribute()));
                break;

            case self::POSITION_END:
                $overElementInterval    = new OverElementInterval($this->interval->getIntervalStarts(), self::carbonize($this->element->endAttribute()));
                break;

            case self::POSITION_THROUGH:
                $overElementInterval = new OverElementInterval($this->interval->getIntervalStarts(), $this->interval->getIntervalEnds());
                break;

            default:
                $overElementInterval = new OverElementInterval($this->interval->getIntervalStarts(), $this->interval->getIntervalEnds());
                break;

        }
        $this->overElementInterval = $overElementInterval;
        $this->elementTicker    = (new IntervalTickersBuilder($this->interval->getIntervalStarts(), $this->interval->getIntervalEnds()));

    }

    protected static function carbonize(string $dateTime, string $format = 'Y-m-d H:i:s')
    {

        return Carbon::createFromFormat($format, $dateTime);
    }

    /**
     * @return TimeLineElementContract
     */
    public function getElement(): TimeLineElementContract
    {
        return $this->element;
    }

    /**
     * @return IntervalBuilderContract
     */
    public function getInterval(): IntervalBuilderContract
    {
        return $this->interval;
    }

    /**
     * @return IntervalBuilder
     */
    public function getOverElementInterval(): IntervalBuilder
    {
        return $this->overElementInterval;
    }

    /**
     * @return IntervalTickersBuilder
     */
    public function getElementTicker(): IntervalTickersBuilder
    {
        return $this->elementTicker;
    }

}
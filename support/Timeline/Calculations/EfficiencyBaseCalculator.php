<?php namespace  app\support\Timeline\Calculations;

use app\support\Timeline\Intervals\IntervalTickersBuilder;

class EfficiencyBaseCalculator
{
    /** @var float */
    protected $absoluteValue;

    /** @var float */
    protected $usedTime;

    /** @var IntervalTickersBuilder */
    protected $intervalTickerBuilder;

    public function __construct(float $absoluteValue, IntervalTickersBuilder $intervalTickersBuilder)
    {
        $this->absoluteValue    = $absoluteValue;
        $this->intervalTickerBuilder    = $intervalTickersBuilder;
    }
    
    public static function make(float $absoluteValue, IntervalTickersBuilder $intervalTickersBuilder) : self
    {
        return new static($absoluteValue, $intervalTickersBuilder);
    }

    public function getBaseEfficiencyValue() : float
    {
        $this->usedTime =  $this->intervalTickerBuilder->usedTimeLength();

        return $this->absoluteValue / $this->usedTime * 24;
    }

    /**
     * @return float
     */
    public function getUsedTime(): float
    {
        return $this->usedTime;
    }
}
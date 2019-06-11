<?php namespace app\support\Timeline\Intervals;

use app\support\StaticCostsCalculators\GoingsBaseCostCalculator;
use app\support\Timeline\Calculations\CumulativeCalculation;
use app\support\Timeline\Calculations\PerpetualCalculation;

class MixedIntervalTicker extends IntervalTicker
{
    /** @var GoingsBaseCostCalculator */
    public $costCalculator;

    /** @var float */
    protected $tickStartValue = 0;

    /** @var string */
    public $periodType = 'diff';

    public function __construct()
    {
        $this->parts = collect([]);
        $this->lastKnotValue = $this->tickStartValue;
    }



    protected function makeTicks()
    {
        $this->lastKnotValue = $chainedValue = $this->tickStartValue;

//        var_dump($chainedValue);
        if ($hasLeft  = $this->getPart('left')){
//            var_dump($hasLeft);
            $this->costCalculator->setLeap()->setMinute();

            $costPerMinute  = $this->costCalculator->cost();

            if ($this->periodType === 'diff'){
                $costPerMinute = $chainedValue;
            }

            $cumulateLeft = $this->makeCalculation($costPerMinute, 'left', $chainedValue);

            $this->lastKnotValue = $chainedValue = $cumulateLeft->result->last()->getValue();

            $this->tickers->put('left', $cumulateLeft);
        }

        if ($this->getPart('middle')) {

            $this->costCalculator->setLeap()->setHour();

            $costPerHour    = $this->costCalculator->cost();
            if ($this->periodType === 'diff'){
                $costPerHour = $chainedValue;
            }
            $cumulateMiddle    = $this->makeCalculation($costPerHour, 'middle', $chainedValue);

            $this->lastKnotValue = $chainedValue = $cumulateMiddle->result->last()->getValue();

            $this->tickers->put('middle', $cumulateMiddle);

        }

        if ($this->getPart('right')) {

            $this->costCalculator->setLeap()->setMinute();

            $costPerMinute    = $this->costCalculator->cost();
            if ($this->periodType === 'diff'){
                $costPerMinute = $chainedValue;
            }

            $cumulateRight = $this->makeCalculation($costPerMinute, 'right', $chainedValue);

//            $this->lastKnotValue = $chainedValue = $cumulateRight->result->last()->getValue();

            $this->tickers->put('right', $cumulateRight);

        }
//
//        var_dump($chainedValue);
    }

    /**
     * @param float $tickStartValue
     */
    public function setTickStartValue(float $tickStartValue)
    {
        $this->tickStartValue = $tickStartValue;
    }

    /**
     * @param $costPerHour
     * @param $position
     * @param $chainedValue

     * @return \app\support\Timeline\Calculations\SteppedCalculationContract
     */
    protected function makeCalculation($costPerHour, $position, $chainedValue):\app\support\Timeline\Calculations\SteppedCalculationContract
    {
//        var_dump($chainedValue);
//        var_dump($costPerHour);
        if ($this->periodType === 'diff'){
            $calculation = PerpetualCalculation::make($this->getPart($position)->periods());
            $calculation->startCost = $chainedValue;
        }else{
            $calculation = CumulativeCalculation::make($this->getPart($position)->periods(), $costPerHour);
            $calculation->startCost = $chainedValue;
        }
        $calculation->calculator = $this->costCalculator;
        $calculation->position = $position;


        $calculation->calculate();
        return $calculation;
    }
}
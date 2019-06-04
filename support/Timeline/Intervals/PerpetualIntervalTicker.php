<?php namespace app\support\Timeline\Intervals;

use app\support\Timeline\Calculations\PerpetualCalculation;

class PerpetualIntervalTicker extends IntervalTicker
{

    protected function makeTicks()
    {
        $chainedValue   = 0;

        if ($hasLeft  = $this->getPart('left')){

            $this->costCalculator->setLeap()->setMinute();

            $costPerMinute  = $this->costCalculator->cost();

            $cumulateLeft = PerpetualCalculation::make($this->getPart('left')->periods(), $costPerMinute);
            $cumulateLeft->position = 'left';
            $cumulateLeft->calculator  = $this->costCalculator;
            $cumulateLeft->calculate();

            $chainedValue = $cumulateLeft->result->last()->getValue();
//            dd($costPerMinute,$chainedValue);
//            dd($cumulateLeft);
            $this->tickers->put('left', $cumulateLeft);
        }

        if ($this->getPart('middle')) {

            $this->costCalculator->setLeap()->setHour();

            $costPerHour    = $this->costCalculator->cost();

            $cumulateMiddle    = PerpetualCalculation::make($this->getPart('middle')->periods(), $costPerHour);
            $cumulateMiddle->position = 'middle';
            $cumulateMiddle->calculator  = $this->costCalculator;
            $cumulateMiddle->startCost  = $costPerHour;

            $cumulateMiddle->calculate();

            $chainedValue = $cumulateMiddle->result->last()->getValue();

            $this->tickers->put('middle', $cumulateMiddle);

        }

        if ($this->getPart('right')) {

            $this->costCalculator->setLeap()->setMinute();

            $costPerHour    = $this->costCalculator->cost();

            $cumulateRight    = PerpetualCalculation::make($this->getPart('right')->periods(), $costPerHour);
            $cumulateRight->position = 'right';
            $cumulateRight->calculator  = $this->costCalculator;
            $cumulateRight->startCost  = $chainedValue;

            $cumulateRight->calculate();

            $this->tickers->put('right', $cumulateRight);

        }

    }

}
<?php namespace app\support\StaticCostsCalculators;

use app\support\StaticCostsCalculators\StaticCostsCalculatorContract;


class GoingsBaseCostCalculator extends BaseStaticCostCalculator implements StaticCostsCalculatorContract
{
    /** @var float */
    public $baseCost = 0;

    public function cost() : float
    {
        if (self::$usedTimeUnit === 'minute'){
            return $this->baseCost / 60;
        }

        return $this->baseCost;
    }
}
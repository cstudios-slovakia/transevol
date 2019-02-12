<?php

namespace app\support\StaticCostsCalculators;

use app\support\StaticCostsCalculators\HourlyCostCalculator;

class HourlyAbsoluteCostsCalculator extends HourlyCostCalculator
{
    /** @var int */
    protected $hourPeriod = 24;

    public function __construct(int $days, float $monthlyCost)
    {
        parent::__construct($this->hourPeriod, $days, $monthlyCost);
    }
}
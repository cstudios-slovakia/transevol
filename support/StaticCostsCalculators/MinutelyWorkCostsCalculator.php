<?php
namespace app\support\StaticCostsCalculators;

class MinutelyWorkCostsCalculator extends HourlyCostCalculator
{
    /** @var int */
    protected $hourPeriod = 1440;

    public function __construct(int $days, float $monthlyCost)
    {
        parent::__construct($this->hourPeriod, $days, $monthlyCost);
    }
}
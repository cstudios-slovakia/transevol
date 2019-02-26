<?php

namespace app\support\Vehicles\VehicleStaticCostCalculators;

class MonthlyCostsPerHourCalculator
{
    /** @var float */
    protected $cost;

    /** @var int */
    protected $hourPeriod;

    public function __construct(float $cost, int $hourPeriod = 24)
    {
        $this->setCost($cost);

        $this->setHourPeriod($hourPeriod);
    }

    public function costPerHour() : float
    {
        return $this->cost / $this->hourPeriod;
    }

    /**
     * @param float $cost
     */
    public function setCost(float $cost)
    {
        $this->cost = $cost;
    }

    /**
     * @param int $hourPeriod
     */
    public function setHourPeriod(int $hourPeriod)
    {
        $this->hourPeriod = $hourPeriod;
    }
}
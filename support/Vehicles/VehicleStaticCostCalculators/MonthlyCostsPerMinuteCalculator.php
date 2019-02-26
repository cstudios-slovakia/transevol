<?php

namespace app\support\Vehicles\VehicleStaticCostCalculators;

class MonthlyCostsPerMinuteCalculator
{
    /** @var float */
    protected $cost;

    /** @var int */
    protected $minutePeriod;

    public function __construct(float $cost, int $minutePeriod = 60)
    {
        $this->setCost($cost);

        $this->setMinutePeriod($minutePeriod);
    }

    public function costPerMinute() : float
    {
        return $this->cost / $this->minutePeriod;
    }

    /**
     * @param float $cost
     */
    public function setCost(float $cost)
    {
        $this->cost = $cost;
    }

    /**
     * @param int $minutePeriod
     */
    public function setMinutePeriod(int $minutePeriod)
    {
        $this->minutePeriod = $minutePeriod;
    }


}
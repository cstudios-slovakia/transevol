<?php

namespace app\support\Vehicles\VehicleStaticCostCalculators;

class MonthlyCostsPerDayCalculator
{
    /**
     * @var int
     */
    protected $days;

    /** @var float */
    protected $monthlyCost;

    public function costPerDay()
    {
        if(!isset($this->days)){
            throw new \Exception('No days specified.');
        }

        if(!isset($this->monthlyCost)){
            throw new \Exception('No monthly cost defined.');
        }

        return $this->monthlyCost / $this->days;
    }

    /**
     * @param int $days
     */
    public function setDays(int $days)
    {
        $this->days = $days;
    }

    /**
     * @param float $monthlyCost
     */
    public function setMonthlyCost(float $monthlyCost)
    {
        $this->monthlyCost = $monthlyCost;
    }


}
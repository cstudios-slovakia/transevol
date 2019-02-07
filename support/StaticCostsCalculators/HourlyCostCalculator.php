<?php

namespace app\support\StaticCostsCalculators;

class HourlyCostCalculator
{
    /** @var int */
    protected $hourPeriod;
    /** @var int */
    protected $days;
    /** @var float */
    protected $monthlyCost;

    public function __construct(int $hourPeriod, int $days, float $monthlyCost)
    {
        $this->setHourPeriod($hourPeriod);
        $this->setDays($days);
        $this->setMonthlyCost($monthlyCost);
    }

    public function costResult(bool $formatted = false) : float
    {
        $cost   = $this->getMonthlyCost();

        $time   = $this->getDays() * $this->getHourPeriod();

        $costResult = $cost / $time;

        if ($formatted){
            $costResult = CostFormatter::format($costResult);
        }

        return $costResult;
    }

    /**
     * @return int
     */
    public function getHourPeriod(): int
    {
        return $this->hourPeriod;
    }

    /**
     * @param int $hourPeriod
     */
    public function setHourPeriod(int $hourPeriod)
    {
        $this->hourPeriod = $hourPeriod;
    }

    /**
     * @return int
     */
    public function getDays(): int
    {
        return $this->days;
    }

    /**
     * @param int $days
     */
    public function setDays(int $days)
    {
        $this->days = $days;
    }

    /**
     * @return float
     */
    public function getMonthlyCost(): float
    {
        return $this->monthlyCost;
    }

    /**
     * @param float $monthlyCost
     */
    public function setMonthlyCost(float $monthlyCost)
    {
        $this->monthlyCost = $monthlyCost;
    }




}

?>
<?php

namespace app\support\StaticCostsCalculators;

use app\models\VehicleStaticCosts;


class StaticCostCalculator
{

    /** @var int  */
    protected $days = 30;

    /** @var VehicleStaticCosts */
    protected $staticCost;

    protected $calculus = 0;



    protected function getCostFrequencyData()
    {
        return $this->getStaticCost()->frequencyData;
    }

    public function costResult($formatted = false) : float
    {
        $this->defineCalculus();

        $periodCost     = $this->getStaticCost()->value;

        $cost   = $periodCost * $this->calculus;

        if ($formatted){
            return CostFormatter::format($cost);
        }

        return $cost;
    }

    protected function defineCalculus()
    {
        $minutesInPeriod     = $this->periodInMinutes();
//        dump($this->getStaticCost());
        $periodTime     = $this->getCostFrequencyData()->frequency_value;

        $this->calculus = $minutesInPeriod / $periodTime;
    }


    protected function periodInMinutes() : int
    {
        return 60 * 24 * $this->getDays();
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
     * @return VehicleStaticCosts
     */
    public function getStaticCost(): VehicleStaticCosts
    {
        return $this->staticCost;
    }

    /**
     * @param VehicleStaticCosts $staticCost
     */
    public function setStaticCost(VehicleStaticCosts $staticCost)
    {
        $this->staticCost = $staticCost;
    }

    /**
     * @return int
     */
    public function getCalculus(): int
    {
        return $this->calculus;
    }

    /**
     * @param int $calculus
     */
    public function setCalculus(int $calculus)
    {
        $this->calculus = $calculus;
    }

}

?>
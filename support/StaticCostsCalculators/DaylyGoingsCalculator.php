<?php

namespace app\support\StaticCostsCalculators;



class DaylyGoingsCalculator
{

    /** @var int */
    protected $workDays = 0;

    /** @var MonthlyStaticCostsCalculator */
    protected $monthlyStaticCostsCalculator;

    protected function getMonthlyStaticCostsResult()
    {
        return $this->monthlyStaticCostsCalculator->costResult();
    }

    public function costResult(bool $formatted = false)
    {
        $cost = $this->getMonthlyStaticCostsResult() / $this->getWorkDays();

        if($formatted){
            return CostFormatter::format($cost);
        }
        return $cost;
    }

    /**
     * @return int
     */
    public function getWorkDays(): int
    {
        return $this->workDays;
    }

    /**
     * @param int $workDays
     */
    public function setWorkDays(int $workDays)
    {
        $this->workDays = $workDays;
    }

    /**
     * @param MonthlyStaticCostsCalculator $monthlyStaticCostsCalculator
     */
    public function setMonthlyStaticCostsCalculator(MonthlyStaticCostsCalculator $monthlyStaticCostsCalculator)
    {
        $this->monthlyStaticCostsCalculator = $monthlyStaticCostsCalculator;
    }



}

?>
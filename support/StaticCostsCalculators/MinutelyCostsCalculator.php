<?php

namespace app\support\StaticCostsCalculators;

class MinutelyCostsCalculator extends StaticCostCalculator
{
    public function costResult($formatted = false) : float
    {

        $periodCost     = $this->getStaticCost()->value;

        $periodMinutes  = $this->getCostFrequencyData()->frequency_value;

        $cost   = $periodCost / $periodMinutes;

        if ($formatted){
            return CostFormatter::format($cost);
        }

        return $cost;
    }
}
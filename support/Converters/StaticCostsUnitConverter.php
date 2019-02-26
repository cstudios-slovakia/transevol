<?php

namespace app\support\Converters;

use app\models\FrequencyData;
use app\models\StaticCost;
use app\models\VehicleStaticCosts;

class StaticCostsUnitConverter
{
    /** @var StaticCost|VehicleStaticCosts */
    protected $staticCosts;

    /**
     * daily, monthly, yearly
     *
     * @var string
     */
    protected $expectedUnit;

    public function convert(string $expected = '') : float
    {
        if (!empty($expected)) {
            $this->expectedUnit = $expected;
        }

        if(!isset($this->expectedUnit)){
            throw new \Exception('Expected unit is not set.');
        }

        return $this->convertToExpected();
    }

    protected function convertToExpected() : float
    {
        return $this->calculus();
    }

    protected function calculus() : float
    {
        $currentUnit = $this->getFrequencyName();

        if ($this->expectedUnit === $currentUnit){
            return 1;
        }

        if ($currentUnit === 'daily' && $this->expectedUnit === 'yearly'){
            return 365;
        }

        if ($currentUnit === 'daily' && $this->expectedUnit === 'monthly'){
            return 30;
        }

        if ($currentUnit === 'monthly'&& $this->expectedUnit === 'yearly' ){
            return 12;
        }

        if ($currentUnit === 'monthly' && $this->expectedUnit === 'daily'){
            return 1/30;
        }

        if ($currentUnit === 'yearly'&& $this->expectedUnit === 'monthly' ){
            return 1/12;
        }

        if ($currentUnit === 'yearly' && $this->expectedUnit === 'daily'){
            return 1/365;
        }
    }

    protected function getFrequencyName() : string
    {
        return $this->staticCosts->frequencyData->frequency_name;
    }

    protected function getCostValue() : float
    {
        return $this->staticCosts->frequencyData->frequency_value;
    }

    protected function getFrequencyData() : FrequencyData
    {
        return $this->staticCosts->frequencyData;
    }


    public function setStaticCosts($staticCosts)
    {
        $this->staticCosts = $staticCosts;
    }

    /**
     * @param string $expectedUnit
     */
    public function setExpectedUnit(string $expectedUnit)
    {
        $this->expectedUnit = $expectedUnit;
    }
}
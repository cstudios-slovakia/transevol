<?php

namespace app\support\Vehicles\VehicleStaticCostCalculators;

use app\models\CompanyCostDatas;
use app\models\VehicleStaticCosts;
use app\support\Converters\StaticCostsUnitConverter;

class VehicleStaticCostsCalculator
{

    /** @var StaticCostsUnitConverter */
    protected $converter;

    /** @var VehicleStaticCosts|CompanyCostDatas  */
    protected $staticCost;

    public function calculateCost() : float
    {
        return $this->staticCost->value * $this->getCalculus();
    }

    protected function getCalculus() : float
    {
        return $this->converter->convert('monthly');
    }

    /**
     * @param StaticCostsUnitConverter $converter
     */
    public function setConverter(StaticCostsUnitConverter $converter)
    {
        $this->converter = $converter;
    }

    /**
     * @param VehicleStaticCosts|CompanyCostDatas $staticCost
     */
    public function setStaticCost($staticCost)
    {
        $this->staticCost = $staticCost;
    }



}
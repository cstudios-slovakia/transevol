<?php namespace app\support\Vehicles;

use app\support\StaticCostsCalculators\StaticCostsCalculatorContract;
use app\support\StaticCostsCalculators\BaseStaticCostCalculator;
use app\support\StaticCostsCalculators\VehicleStaticCostsSummarizer;

class VehicleStaticCostsCalculator extends BaseStaticCostCalculator implements StaticCostsCalculatorContract
{



    /** @var VehicleStaticCostsSummarizer */
    protected $vehicleStaticCostsSummarizer;

    public function cost() : float
    {
//        dd($this->unitToUse());
        return $this->vehicleStaticCostsSummarizer->summarizedVehicleCosts()->{$this->unitToUse()};
    }


    /**
     * @param VehicleStaticCostsSummarizer $vehicleStaticCostsSummarizer
     */
    public function setVehicleStaticCostsSummarizer(VehicleStaticCostsSummarizer $vehicleStaticCostsSummarizer)
    {
        $this->vehicleStaticCostsSummarizer = $vehicleStaticCostsSummarizer;
    }

}
<?php namespace app\support\Vehicles;

class UnusedVehicleStaticCostsCalculator extends VehicleStaticCostsCalculator
{

    /**
     * @var int
     */
    public $mainVehiclesAmount = 1;

    public function cost() : float
    {
        return $this->vehicleStaticCostsSummarizer->summarizedVehicleCosts()->{$this->unitToUse()}  / $this->mainVehiclesAmount;
    }


}
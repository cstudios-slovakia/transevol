<?php namespace app\support\Timeline\Vehicles;

use app\models\Vehicles;
use Illuminate\Support\Collection;

class VehicleSeparatorInTimeLine
{

    /** @var DetectVehiclesInInterval */
    protected $vehiclesDetector;

    /** @var UnusedVehiclesInInterval */
    protected $unusedVehiclesDetector;

    public function __construct(DetectVehiclesInInterval $vehiclesDetector)
    {
        $this->vehiclesDetector     = $vehiclesDetector;

    }

    protected function usedVehicleIds() : Collection
    {
        $usedVehicleIds     =  $this->vehiclesDetector->detect(true,function ($vehicleTimeLineElements){
            return $vehicleTimeLineElements->pluck('vehicle_id')->unique();
        });

        return $usedVehicleIds;
    }

    protected function searchForUnusedVehicles() : self
    {
        $usedVehicleIds     =  $this->vehiclesDetector->detect(true,function ($vehicleTimeLineElements){
            return $vehicleTimeLineElements->pluck('vehicle_id')->unique();
        });

        $this->unusedVehiclesDetector   = (new UnusedVehiclesInInterval($usedVehicleIds->toArray()));

        return $this;
    }


    public function getUnusedVehicleIds() : Collection
    {
        return $this->searchForUnusedVehicles()->unusedVehiclesDetector->detect(function ($vehicles){
            return $vehicles->pluck('id');
        });
    }

    /**
     * @param DetectVehiclesInInterval $vehiclesDetector
     * @return VehicleSeparatorInTimeLine
     */
    public function setVehiclesDetector(DetectVehiclesInInterval $vehiclesDetector): VehicleSeparatorInTimeLine
    {
        $this->vehiclesDetector = $vehiclesDetector;
        return $this;
    }

    /**
     * @param UnusedVehiclesInInterval $unusedVehiclesDetector
     * @return VehicleSeparatorInTimeLine
     */
    public function setUnusedVehiclesDetector(UnusedVehiclesInInterval $unusedVehiclesDetector): VehicleSeparatorInTimeLine
    {
        $this->unusedVehiclesDetector = $unusedVehiclesDetector;
        return $this;
    }



}
<?php namespace app\support\Timeline\Vehicles;

use app\models\Vehicles;
use app\models\VehicleTypes;
use app\support\Timeline\Intervals\TimeLineElementOverInterval;
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

        $notMainVehiclesOverInterval    = $this->vehiclesDetector->getElementsOverInterval()->filter(function(TimeLineElementOverInterval $elementOverInterval){
            if ($elementOverInterval->getElement()->type_shortly !== VehicleTypes::MAIN_VEHICLE_SHORT_NAME){
                return $elementOverInterval;
            }
        });

        $unUsedDetector     = new UnusedVehiclesInInterval($notMainVehiclesOverInterval);


        $this->unusedVehiclesDetector   = $unUsedDetector;

        return $this;
    }


    public function getUnusedVehiclesData() : Collection
    {
        $this->searchForUnusedVehicles();

        if ( ! $this->unusedVehiclesDetector){
            throw new \Exception('Unused vehicles are not set for detection.');
        }

        return $this->unusedVehiclesDetector->unUsedIntervals();
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
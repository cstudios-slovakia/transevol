<?php namespace app\support\Timeline\Vehicles;

use app\models\Calculations\TimeLine\VehicleTimeLineElement;
use app\models\TimelineVehicle;
use app\models\Vehicles;
use app\models\VehicleTypes;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\db\mssql\PDO;
use yii\db\Query;

class DetectVehiclesInInterval
{
    /** @var Carbon */
    protected $intervalStart;

    /** @var Carbon */
    protected $intervalEnd;

    /** @var Vehicles */
    protected $vehicle;

    /**
     * @var Collection
     */
    protected $detectedVehicles;

    public function __construct()
    {
//        $this->detectedVehicles = collect([]);
    }

    protected function query() : array
    {
        $vehicleId  = $this->vehicle->id;
        $intervalStart  = $this->intervalStart->format('Y-m-d H:i');
        $intervalEnd  = $this->intervalEnd->format('Y-m-d H:i');

        $rawQuery = "SELECT timeline_vehicle.*, vehicles.ecv,vehicle_types.type_shortly,
       (
         CASE
          WHEN (:intervalStart <= timeline_vehicle.vehicle_record_from
               AND
               :intervalEnd >= timeline_vehicle.vehicle_record_until)
            THEN 'inners'
          WHEN (:intervalStart <= timeline_vehicle.vehicle_record_from
               AND
                :intervalEnd >= timeline_vehicle.vehicle_record_from
                AND
               :intervalEnd <= timeline_vehicle.vehicle_record_until)
            THEN 'beginners'
          WHEN (:intervalStart >= timeline_vehicle.vehicle_record_from
                AND
                :intervalStart <= timeline_vehicle.vehicle_record_until
                AND
                :intervalEnd >= timeline_vehicle.vehicle_record_until)
            THEN 'enders'
          WHEN  (:intervalStart >= timeline_vehicle.vehicle_record_from
               AND
               :intervalEnd <= timeline_vehicle.vehicle_record_until)
            THEN 'throughers'
        END
       ) AS position_status,
  (
    CASE
    WHEN (:intervalStart <= timeline_vehicle.vehicle_record_from
          AND
          :intervalEnd >= timeline_vehicle.vehicle_record_until)
      THEN TIMESTAMPDIFF(MINUTE,timeline_vehicle.vehicle_record_from,timeline_vehicle.vehicle_record_until )
    WHEN (:intervalStart <= timeline_vehicle.vehicle_record_from
          AND
          :intervalEnd >= timeline_vehicle.vehicle_record_from
          AND
          :intervalEnd <= timeline_vehicle.vehicle_record_until)
      THEN TIMESTAMPDIFF(MINUTE,timeline_vehicle.vehicle_record_from,:intervalEnd )
    WHEN (:intervalStart >= timeline_vehicle.vehicle_record_from
          AND
          :intervalStart <= timeline_vehicle.vehicle_record_until
          AND
          :intervalEnd >= timeline_vehicle.vehicle_record_until)
      THEN TIMESTAMPDIFF(MINUTE,:intervalStart,timeline_vehicle.vehicle_record_until )
    WHEN  (:intervalStart >= timeline_vehicle.vehicle_record_from
           AND
           :intervalEnd <= timeline_vehicle.vehicle_record_until)
      THEN TIMESTAMPDIFF(MINUTE,:intervalStart,:intervalEnd )
    END
  ) AS interval_minutes
FROM timeline_vehicle
JOIN going__vehicle
ON timeline_vehicle.id = going__vehicle.going_id
 
AND (
        (:intervalStart <= timeline_vehicle.vehicle_record_from
         AND
         :intervalEnd >= timeline_vehicle.vehicle_record_until)
        OR
        (:intervalStart <= timeline_vehicle.vehicle_record_from
         AND
         :intervalEnd >= timeline_vehicle.vehicle_record_from
         AND
         :intervalEnd <= timeline_vehicle.vehicle_record_until)
        OR
        (:intervalStart >= timeline_vehicle.vehicle_record_from
         AND
         :intervalStart <= timeline_vehicle.vehicle_record_until
         AND
         :intervalEnd >= timeline_vehicle.vehicle_record_until)
        OR
        (:intervalStart >= timeline_vehicle.vehicle_record_from
         AND
         :intervalEnd <= timeline_vehicle.vehicle_record_until)
      )
JOIN vehicles
ON timeline_vehicle.vehicle_id = vehicles.id
JOIN vehicle_types
ON vehicles.vehicle_types_id = vehicle_types.id
      ";

        $dbCommand = \Yii::$app->db->createCommand($rawQuery);
        $dbCommand->bindParam(":intervalStart", $intervalStart, PDO::PARAM_STR);
        $dbCommand->bindParam(":intervalEnd", $intervalEnd, PDO::PARAM_STR);

        return $dbCommand->queryAll();

    }

    /**
     * Run detection on defined datetime interval.
     *
     * @param  boolean $populatedModel
     * @return Collection
     */
    public function detect(bool $populatedModel = true, ...$arguments) : Collection
    {
        if ( ! $populatedModel){
            return collect($this->query());
        }

        $models     = [];

        foreach ($this->query() as $record){

            $vehicleTimeLineElement = new VehicleTimeLineElement();
            $vehicleTimeLineElement->load($record,'');
            $models[]   = $vehicleTimeLineElement;
        }

        $this->detectedVehicles     = $models = collect($models);

        foreach ($arguments as $argument){
            if (is_callable($argument)){
                return call_user_func($argument,$models);
            }
        }

        return $models;
    }

    public function mainVehiclesCounter() : int
    {
        if ( ! isset($this->detectedVehicles)){
            $this->detect();
        }

        return $this->detectedVehicles->filter(function(VehicleTimeLineElement $vehicleTimeLineElement){

            if ($vehicleTimeLineElement->type_shortly === VehicleTypes::MAIN_VEHICLE_SHORT_NAME) {

                return $vehicleTimeLineElement;
            }
        })->count();
    }

    /**
     * @param Carbon $intervalStart
     * @return DetectVehiclesInInterval
     */
    public function setIntervalStart(Carbon $intervalStart): DetectVehiclesInInterval
    {
        $this->intervalStart = $intervalStart;
        return $this;
    }

    /**
     * @param Carbon $intervalEnd
     * @return DetectVehiclesInInterval
     */
    public function setIntervalEnd(Carbon $intervalEnd): DetectVehiclesInInterval
    {
        $this->intervalEnd = $intervalEnd;
        return $this;
    }

    /**
     * @param Vehicles $vehicle
     * @return DetectVehiclesInInterval
     */
    public function setVehicle(Vehicles $vehicle): DetectVehiclesInInterval
    {
        $this->vehicle = $vehicle;
        return $this;
    }


    /**
     * Table name to search on.
     *
     * @return string
     */
    protected function usedTableName() : string
    {
        return TimelineVehicle::tableName();
    }

    /**
     * @return Collection
     */
    public function getDetectedVehicles(): Collection
    {
        return $this->detectedVehicles;
    }


}
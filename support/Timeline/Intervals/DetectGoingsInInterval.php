<?php namespace app\support\Timeline\Intervals;

use app\models\Goings;
use app\models\Vehicles;
use app\support\Timeline\Units\Goings\GoingTimeLineElement;
use Illuminate\Support\Collection;
use yii\db\mssql\PDO;

class DetectGoingsInInterval
{
    use IntervalEndpointsFinder;

    /** @var Vehicles */
    protected $vehicle;

    /** @var Collection */
    protected $elementsOverInterval;

    /** @var Collection */
    protected $detectedGoings;

    public function __construct()
    {
        $this->elementsOverInterval = collect([]);
    }

    protected function query() : array
    {
        $vehicleId  = $this->vehicle->id;
        $intervalStart  = $this->intervalStarts->format('Y-m-d H:i');
        $intervalEnd  = $this->intervalEnds->format('Y-m-d H:i');

        $rawQuery = "SELECT goings.*, 
       (
         CASE
          WHEN (:intervalStart <= goings.going_from
               AND
               :intervalEnd >= goings.going_until)
            THEN 'inners'
          WHEN (:intervalStart <= goings.going_from
               AND
                :intervalEnd >= goings.going_from
                AND
               :intervalEnd <= goings.going_until)
            THEN 'beginners'
          WHEN (:intervalStart >= goings.going_from
                AND
                :intervalStart <= goings.going_until
                AND
                :intervalEnd >= goings.going_until)
            THEN 'enders'
          WHEN  (:intervalStart >= goings.going_from
               AND
               :intervalEnd <= goings.going_until)
            THEN 'throughers'
        END
       ) AS position_status,
  (
    CASE
    WHEN (:intervalStart <= goings.going_from
          AND
          :intervalEnd >= goings.going_until)
      THEN TIMESTAMPDIFF(MINUTE,goings.going_from,goings.going_until )
    WHEN (:intervalStart <= goings.going_from
          AND
          :intervalEnd >= goings.going_from
          AND
          :intervalEnd <= goings.going_until)
      THEN TIMESTAMPDIFF(MINUTE,goings.going_from,:intervalEnd )
    WHEN (:intervalStart >= goings.going_from
          AND
          :intervalStart <= goings.going_until
          AND
          :intervalEnd >= goings.going_until)
      THEN TIMESTAMPDIFF(MINUTE,:intervalStart,goings.going_until )
    WHEN  (:intervalStart >= goings.going_from
           AND
           :intervalEnd <= goings.going_until)
      THEN TIMESTAMPDIFF(MINUTE,:intervalStart,:intervalEnd )
    END
  ) AS interval_minutes
FROM goings
JOIN going__vehicle
ON goings.id = going__vehicle.going_id
 
AND (
        (:intervalStart <= goings.going_from
         AND
         :intervalEnd >= goings.going_until)
        OR
        (:intervalStart <= goings.going_from
         AND
         :intervalEnd >= goings.going_from
         AND
         :intervalEnd <= goings.going_until)
        OR
        (:intervalStart >= goings.going_from
         AND
         :intervalStart <= goings.going_until
         AND
         :intervalEnd >= goings.going_until)
        OR
        (:intervalStart >= goings.going_from
         AND
         :intervalEnd <= goings.going_until)
      )

      ";

        $dbCommand = \Yii::$app->db->createCommand($rawQuery);
        $dbCommand->bindParam(":intervalStart", $intervalStart, PDO::PARAM_STR);
        $dbCommand->bindParam(":intervalEnd", $intervalEnd, PDO::PARAM_STR);
        $dbCommand->queryAll();

//        $x = $dbCommand->rawSql;
//
//        dd($x);
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

        $intervalBuilder = new IntervalBuilder($this->intervalStarts, $this->intervalEnds);
//        dd($this->query());

        foreach ($this->query() as $record){

            $timeLineElement = new GoingTimeLineElement();
            $timeLineElement->load($record,'');
            $models[]   = $timeLineElement;
//            dd($timeLineElement,$record, $this->query());
            $elementOverInterval    = new TimeLineElementOverInterval($intervalBuilder, $timeLineElement);


            $this->elementsOverInterval->push($elementOverInterval);
        }

        $this->detectedGoings     = $models = collect($models);

        foreach ($arguments as $argument){
            if (is_callable($argument)){
                return call_user_func($argument,$models);
            }
        }

        return $models;
    }


    /**
     * @param Vehicles $vehicle
     * @return self
     */
    public function setVehicle(Vehicles $vehicle): self
    {
        $this->vehicle = $vehicle;
        return $this;
    }

}
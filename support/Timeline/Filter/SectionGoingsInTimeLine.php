<?php namespace app\support\Timeline\Filter;

use app\support\Timeline\CalculationIntervalBuilder;
use app\support\Timeline\Intervals\SessionDefinedIntervals;
use app\support\Timeline\SessionDefinedVehicle;
use app\support\Transporter\IntervalParts;
use yii\db\mssql\PDO;

class SectionGoingsInTimeLine extends TimeLineGoings
{

    /** @var SessionDefinedVehicle */
    protected $sessionDefinedVehicleResolver;

    protected $intervalBuilder;

    protected $vehicleId;

    public function __construct()
    {
        $sessionDefinedVehicleResolver = \Yii::$container->get(SessionDefinedVehicle::class);

        $this->sessionDefinedVehicleResolver = $sessionDefinedVehicleResolver;

        $this->vehicleId    = $this->getVehicleId();

        $calculationIntervalDetector = new CalculationIntervalBuilder(new IntervalParts(), new SessionDefinedIntervals());
        $calculationFrom    = $calculationIntervalDetector->getTimeLineInterval(CalculationIntervalBuilder::TIMELINE_FROM_KEY, false, 'Y-m-d H:i');
        $calculationUntil    = $calculationIntervalDetector->getTimeLineInterval(CalculationIntervalBuilder::TIMELINE_UNTIL_KEY, false, 'Y-m-d H:i');

        $this->timeLineFrom = $calculationFrom;
        $this->timeLineUntil = $calculationUntil;

        $this->intervalBuilder = $calculationIntervalDetector;
    }

    /**
     * @return int
     */
    public function getVehicleId() : int
    {
        return $this->sessionDefinedVehicleResolver->getDefinedVehicleId();
    }



    public function run()
    {

        $rawQuery = "SELECT goings.*,
       (
         CASE
          WHEN (:going_from <= goings.going_from
               AND
               :going_until >= goings.going_until)
            THEN 'inners'
          WHEN (:going_from <= goings.going_from
               AND
                :going_until >= goings.going_from
                AND
               :going_until <= goings.going_until)
            THEN 'beginners'
          WHEN (:going_from >= goings.going_from
                AND
                :going_from <= goings.going_until
                AND
                :going_until >= goings.going_until)
            THEN 'enders'
          WHEN  (:going_from >= goings.going_from
               AND
               :going_until <= goings.going_until)
            THEN 'throughers'
        END
       ) AS position_status,
  (
    CASE
    WHEN (:going_from <= goings.going_from
          AND
          :going_until >= goings.going_until)
      THEN TIMESTAMPDIFF(MINUTE,goings.going_from,goings.going_until )
    WHEN (:going_from <= goings.going_from
          AND
          :going_until >= goings.going_from
          AND
          :going_until <= goings.going_until)
      THEN TIMESTAMPDIFF(MINUTE,goings.going_from,:going_until )
    WHEN (:going_from >= goings.going_from
          AND
          :going_from <= goings.going_until
          AND
          :going_until >= goings.going_until)
      THEN TIMESTAMPDIFF(MINUTE,:going_from,goings.going_until )
    WHEN  (:going_from >= goings.going_from
           AND
           :going_until <= goings.going_until)
      THEN TIMESTAMPDIFF(MINUTE,:going_from,:going_until )
    END
  ) AS interval_minutes
FROM goings
JOIN going__vehicle
ON goings.id = going__vehicle.going_id
WHERE going__vehicle.vehicle_id = 1
AND (
        (:going_from <= goings.going_from
         AND
         :going_until >= goings.going_until)
        OR
        (:going_from <= goings.going_from
         AND
         :going_until >= goings.going_from
         AND
         :going_until <= goings.going_until)
        OR
        (:going_from >= goings.going_from
         AND
         :going_from <= goings.going_until
         AND
         :going_until >= goings.going_until)
        OR
        (:going_from >= goings.going_from
         AND
         :going_until <= goings.going_until)
      )";

        $dbCommand = \Yii::$app->db->createCommand($rawQuery);
        $dbCommand->bindParam(":going_from", $this->timeLineFrom, PDO::PARAM_STR);
        $dbCommand->bindParam(":going_until", $this->timeLineUntil, PDO::PARAM_STR);
        $goings = $dbCommand->queryAll();

        return $goings;


    }

    /**
     * @return CalculationIntervalBuilder
     */
    public function getIntervalBuilder(): CalculationIntervalBuilder
    {
        return $this->intervalBuilder;
    }


}
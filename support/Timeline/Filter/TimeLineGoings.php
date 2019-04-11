<?php namespace app\support\Timeline\Filter;

use app\models\Goings;
use yii\db\ActiveQuery;

class TimeLineGoings
{

    /** @var string */
    protected $timeLineFrom;

    /** @var string */
    protected $timeLineUntil;

    /** @var int */
    protected $vehicleId;

    protected function run()
    {

        return Goings::find()
            ->joinWith([
                'vehicles'  => function (ActiveQuery $query) {
                    $query->andWhere(['vehicles.id' => $this->vehicleId]);
                }
            ])
            ->where(['between','going_from',$this->timeLineFrom,$this->timeLineUntil])
            ->orWhere(['between','going_until',$this->timeLineFrom,$this->timeLineUntil])
            ->all();
    }


    public function getTimeLineGoingsRecords()
    {
        return $this->run();
    }

    /**
     * @param string $timeLineFrom
     */
    public function setTimeLineFrom(string $timeLineFrom)
    {
        $this->timeLineFrom = $timeLineFrom;
    }

    /**
     * @param string $timeLineUntil
     */
    public function setTimeLineUntil(string $timeLineUntil)
    {
        $this->timeLineUntil = $timeLineUntil;
    }

    /**
     * @param int $vehicleId
     */
    public function setVehicleId(int $vehicleId)
    {
        $this->vehicleId = $vehicleId;
    }

    /**
     * @return string
     */
    public function getTimeLineFrom(): string
    {
        return $this->timeLineFrom;
    }

    /**
     * @return string
     */
    public function getTimeLineUntil(): string
    {
        return $this->timeLineUntil;
    }

    /**
     * @return int
     */
    public function getVehicleId(): int
    {
        return $this->vehicleId;
    }


}
<?php namespace app\support\Timeline;

use app\models\Vehicles;

/**
 * Class SessionDefinedVehicle
 * @package app\support\Timeline
 */
class SessionDefinedVehicle
{
    const TIMELINE_VEHICLE_KEY = 'vehicleId';

    /** @var int */
    protected $vehicleId;

    /**
     * @var mixed|\yii\web\Session
     */
    protected $session;

    /**
     * SessionDefinedVehicle constructor.
     */
    public function __construct()
    {
        $this->session = \Yii::$app->session;
    }

    /**
     * @param string $key
     * @return bool
     */
    protected function check(string $key) : bool
    {
        return $this->session->has($key);
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function getDefinedVehicleId() : ?int
    {
        if( ! $this->check($key = self::TIMELINE_VEHICLE_KEY)){
            return null;
        }

        return $this->vehicleId = $this->session->get($key);
    }

    /**
     * @param int $id
     */
    public function defineVehicleId(int $id)
    {
        $this->session->set(self::TIMELINE_VEHICLE_KEY, $id);

        $this->vehicleId = $id;
    }



}
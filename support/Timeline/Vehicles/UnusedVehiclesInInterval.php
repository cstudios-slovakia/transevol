<?php namespace app\support\Timeline\Vehicles;

use app\models\Vehicles;
use Illuminate\Support\Collection;
use yii\db\Query;


class UnusedVehiclesInInterval
{
    /** @var array */
    protected $vehiclesIdInUse;

    public function __construct(array $vehiclesIdInUse)
    {
        $this->vehiclesIdInUse = $vehiclesIdInUse;
    }

    protected function query() : Query
    {
        return Vehicles::find()->where(['not in', 'id', $this->vehiclesIdInUse]);
    }

    public function detect(...$arguments) : Collection
    {
        foreach ($arguments as $argument){
            if (is_callable($argument)) {
                return call_user_func($argument, collect($this->query()->all()));
            }
        }

        return collect($this->query()->all());

    }
}
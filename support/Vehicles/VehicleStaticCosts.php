<?php

namespace app\support\Vehicles;

use app\models\Drivers;
use app\models\Vehicles;

class VehicleStaticCosts
{
    protected $model;

    public function __construct(Vehicles $drivers)
    {
        $this->setModel($drivers);
    }

    protected function load()
    {
        return $this->getModel()->vehicleStaticCosts;
    }

    public function relations()
    {
        $relations = collect($this->load());

        return $relations->keyBy(function($related){
            return $related->staticCosts->short_name;
        });
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

}
<?php

namespace app\support\Drivers;

use app\models\Drivers;

class DriverStaticCosts
{
    protected $model;

    public function __construct(Drivers $drivers)
    {
        $this->setModel($drivers);
    }

    protected function load()
    {
        return $this->getModel()->driverCostDatas;
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
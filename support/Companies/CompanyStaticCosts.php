<?php

namespace app\support\Companies;

use app\models\Companies;

class CompanyStaticCosts
{
    protected $model;

    public function __construct(Companies $model)
    {
        $this->setModel($model);
    }

    protected function load()
    {
        return $this->getModel()->companyCostDatas;
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
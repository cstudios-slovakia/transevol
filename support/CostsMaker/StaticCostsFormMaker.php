<?php

namespace app\support\CostsMaker;

use app\models\Companies;
use app\models\Drivers;
use app\models\StaticCost;
use app\models\StaticCostsForm;
use app\models\Vehicles;
use app\support\Companies\CompanyStaticCosts;
use app\support\Vehicles\VehicleStaticCosts;
use app\support\Drivers\DriverStaticCosts;
use yii\base\Model;

class StaticCostsFormMaker
{
    protected $staticCost;
    protected $model;
    protected $record;

    /** @var  Model */
    protected $source;

    public static function load(Model $model)
    {
        $self = new static();

        $self->setModel($model);

        return $self;
    }

    public function make(StaticCost $staticCost)
    {
        $this->setStaticCost($staticCost);

        $this->makeStaticCostForm();

        return $this->getRecord();
    }

    public function withErrors($source)
    {

        $this->source = $source;

        return $this;
    }

    protected function makeStaticCostForm()
    {
        if (!$staticCost = $this->getStaticCost()) {
            throw new \Exception('No static cost is set.');
        }

        $record     = new StaticCostsForm();
        $record->cost_name          = $staticCost->cost_name;
        $record->cost_section       = $staticCost->cost_section;
        $record->short_name         = $staticCost->short_name;

        if(! $this->getModel()->id){
            $record->value = null;
            $record->frequency_datas_id = null;

        } else{
            $relations = $this->costDatasForModel();
//            $costData = $relations->has($record->short_name) ? $relations->get($record->short_name)->value : null;
            $costData = $relations->has($record->short_name) ? $relations->get($record->short_name): null;
            $record->value = $costData ? $costData->value: null;
            $record->frequency_datas_id = $costData->frequency_datas_id;

        }
//dd($this->source);
        if (array_key_exists($record->short_name,$this->source->getErrors())){
            $record->value = $this->source->{$record->short_name}['value'];
            $record->addError($record->short_name, $this->source->getFirstError($record->short_name));

        }

        $record->units_id           = $staticCost->units_id;
        $record->unit_name          = $staticCost->units->unit_name;
        $record->frequency_group_name = $staticCost->frequencyGroup->frequency_group_name;


        $this->setRecord($record);

        return $this;
    }

    protected function costDatasForModel()
    {
        $model = $this->getModel();

        $relation = null;

        if ($model instanceof Drivers){
            $relation   = new DriverStaticCosts($model);
        } elseif ($model instanceof Vehicles){
            $relation   = new VehicleStaticCosts($model);
        } elseif ($model instanceof Companies) {
            $relation   = new CompanyStaticCosts($model);
        }

        if(! $relation){
            throw new \Exception('No model.');
        }

        if(method_exists($relation,'relations')){
            return $relation->relations();
        }
    }

    /**
     * @return mixed
     */
    public function getStaticCost()
    {
        return $this->staticCost;
    }

    /**
     * @param mixed $staticCost
     */
    public function setStaticCost($staticCost)
    {
        $this->staticCost = $staticCost;
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

    /**
     * @return mixed
     */
    public function getRecord()
    {
        return $this->record;
    }

    /**
     * @param mixed $record
     */
    public function setRecord($record)
    {
        $this->record = $record;
    }


}
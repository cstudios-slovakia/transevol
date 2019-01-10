<?php

namespace app\components\ModelTyped\Validators;

use yii\validators\Validator;

class StaticCostInputValidator extends Validator
{
    public $skipOnEmpty = false;
    public $skipOnError = false;

    public function validateAttribute($model, $attribute)
    {

        if (  !is_numeric($model->$attribute['value']) || !is_numeric($model->$attribute['frequency_datas_id'])){

            $this->addError($model, $attribute, \Yii::t('static_costs','Value should be numeric {value}') );
        }

    }
}
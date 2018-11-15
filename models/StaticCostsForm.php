<?php

namespace app\models;

use yii\base\Model;

class StaticCostsForm extends Model
{
    public $short_name;
    public $cost_name;
    public $value;
    public $cost_section;
    public $units_id;
    public $unit_name;
    public $frequency_datas_id;
    public $frequency_group_name;

    public function rules()
    {
        return [
            [[ 'value', 'frequency_datas_id'  ], 'required']
        ];

    }



}
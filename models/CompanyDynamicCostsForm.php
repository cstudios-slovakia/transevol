<?php

namespace app\models;

use yii\base\Model;

class CompanyDynamicCostsForm extends Model
{
    public $value;
    public $cost_type;
    public $cost_name;
    public $is_update;

    public function rules()
    {
        return [
            [ ['value', 'cost_type', 'cost_name', 'is_update' ], 'required' ],
            [ 'value' , 'number' ],
            [ [ 'cost_type', 'cost_name' ], 'string' ],
            [ 'is_update' , 'boolean' ],
        ];

    }
}
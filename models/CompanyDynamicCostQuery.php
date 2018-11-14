<?php

namespace app\models;

use yii\db\ActiveQuery;

class CompanyDynamicCostQuery extends ActiveQuery
{
    public $cost_type;

    public function prepare($builder)
    {
        if ($this->cost_type !== null) {
            $this->andWhere(['cost_type' => $this->cost_type]);
        }
        return parent::prepare($builder);
    }
}
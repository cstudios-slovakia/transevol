<?php

namespace app\models;

use yii\db\ActiveQuery;

class StaticCostQuery extends ActiveQuery
{
    public $cost_section;

    public function prepare($builder)
    {
        if ($this->cost_section !== null) {
            $this->andWhere(['cost_section' => $this->cost_section]);
        }
        return parent::prepare($builder);
    }
}
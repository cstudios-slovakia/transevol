<?php

namespace app\models;

use yii\db\ActiveQuery;

class CompanyOwnedQuery extends ActiveQuery
{
    public $id;

    public function prepare($builder)
    {
        if ($this->id !== null) {
            $this->andWhere(['id' => $this->id]);
        }
        return parent::prepare($builder);
    }
}
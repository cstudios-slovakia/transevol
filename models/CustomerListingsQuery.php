<?php

namespace app\models;

use yii\db\ActiveQuery;

class CustomerListingsQuery extends ActiveQuery
{
    public $placetype_name;

    public function prepare($builder)
    {
        if ($this->placetype_name !== null) {
            $this->andWhere(['placetype_name' => $this->placetype_name]);
        }
        return parent::prepare($builder);
    }
}
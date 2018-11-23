<?php

namespace app\models;

use yii\db\ActiveQuery;

class ListingsByTypeQuery extends ActiveQuery
{
    public $placetype_name;

    public function prepare($builder)
    {
        if ($this->placetype_name !== null) {
            $this->placeTypes()
            ->andWhere(['placetype_name' => $this->placetype_name]);
        }
        return parent::prepare($builder);
    }
}
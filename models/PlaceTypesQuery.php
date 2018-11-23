<?php

namespace app\models;

use yii\db\ActiveQuery;

class PlaceTypesQuery extends ActiveQuery
{
    public $place_section;

    public function prepare($builder)
    {
        if ($this->place_section !== null) {
            $this->andWhere(['place_section' => $this->place_section]);
        }
        return parent::prepare($builder);
    }
}
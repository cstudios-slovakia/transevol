<?php

namespace app\models;

class ListingsPlaceTypesQuery extends PlaceTypes
{
    const SECTION = 'listings';

    public static function find()
    {
        return new PlaceTypesQuery(get_called_class(), ['where' =>
            ['place_section' => self::SECTION]]);
    }
}
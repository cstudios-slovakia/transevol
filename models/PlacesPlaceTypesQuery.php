<?php

namespace app\models;

class PLacesPlaceTypesQuery extends PlaceTypes
{
    const SECTION = 'places';

    public static function find()
    {
        return new PlaceTypesQuery(get_called_class(), ['where' =>
            ['place_section' => self::SECTION]]);
    }
}
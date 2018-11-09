<?php

namespace app\models;

class VehicleStaticCost extends StaticCost
{
    const SECTION = 'vehicle';

    public static function find()
    {
        return new StaticCostQuery(get_called_class(), ['where' =>
            ['cost_section' => self::SECTION]]);
    }
}
<?php

namespace app\models;

class DriverStaticCost extends StaticCost
{
    const SECTION = 'driver';

    public static function find()
    {
        return new StaticCostQuery(get_called_class(), ['where' =>
            ['cost_section' => self::SECTION]]);
    }
}
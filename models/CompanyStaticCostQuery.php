<?php

namespace app\models;

class CompanyStaticCostQuery extends StaticCost
{
    const SECTION = 'company';

    public static function find()
    {
        return new StaticCostQuery(get_called_class(), ['where' =>
            ['cost_section' => self::SECTION]]);
    }
}
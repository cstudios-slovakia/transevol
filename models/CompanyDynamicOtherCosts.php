<?php

namespace app\models;

class CompanyDynamicOtherCosts extends CompanyDynamicCosts
{
    const SECTION = 'other';

    public static function find()
    {
        return new CompanyDynamicCostQuery(get_called_class(), ['where' =>
            ['cost_type' => self::SECTION]]);
    }
}
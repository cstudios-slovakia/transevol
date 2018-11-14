<?php

namespace app\models;

class CompanyDynamicPersonalCosts extends CompanyDynamicCosts
{
    const SECTION = 'perso';

    public static function find()
    {
        return new CompanyDynamicCostQuery(get_called_class(), ['where' =>
            ['cost_type' => self::SECTION]]);
    }
}
<?php

namespace app\support\StaticCostsCalculators;

class CostFormatter
{
    public static function format(float $cost)
    {
        return number_format($cost, 2,'.','');
    }
}
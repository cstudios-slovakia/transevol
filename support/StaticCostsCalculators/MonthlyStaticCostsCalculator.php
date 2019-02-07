<?php

namespace app\support\StaticCostsCalculators;

class MonthlyStaticCostsCalculator extends StaticCostCalculator
{

    /** @var int  */
    protected $days = 30;

    public static function getMonthDays() : int
    {
        return (new self())->getDays();
    }

}
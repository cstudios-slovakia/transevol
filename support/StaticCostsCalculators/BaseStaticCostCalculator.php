<?php namespace app\support\StaticCostsCalculators;

abstract class BaseStaticCostCalculator
{
    public static $isLeapYear = false;
    public static $usedTimeUnit     = 'hour';

    protected function unitToUse() : string
    {
        $unit   = self::$usedTimeUnit;

        $year   = self::$isLeapYear ? 'leap' : 'standard';

        return $unit .'_'.$year;
    }

    public function setLeap()
    {
        self::$isLeapYear = true;

        return $this;
    }

    public function setMinute()
    {
        self::$usedTimeUnit = 'minute';

        return $this;
    }

    public function setHour()
    {
        self::$usedTimeUnit = 'hour';

        return $this;
    }
}
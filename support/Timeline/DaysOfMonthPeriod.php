<?php

namespace app\support\Timeline;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterval;

class DaysOfMonthPeriod
{

    protected $actualMonth;

    public function __construct(\DateTimeInterface $actualMonth = null)
    {
        if( ! $actualMonth){

            $actualMonth = self::getCurrentDateTime();

        }

        $this->actualMonth = $actualMonth;

    }

    public function lastDayOfMonth() : CarbonImmutable
    {

        return $this->actualMonth->lastOfMonth()->add(CarbonInterval::day(1));
    }

    public function firstDayMonth() : CarbonImmutable
    {
        return $this->actualMonth->firstOfMonth();
    }

    public static function defineMonth() : CarbonImmutable
    {

        if(static::isPostDefinedDate())
        {
            $postDefinedDate  = \Yii::$app->request->post('definedDate');

            return $definedDate  = CarbonImmutable::createFromFormat('m/d/Y', $postDefinedDate);
        }

        return self::getCurrentDateTime();
    }

    public static function isPostDefinedDate() : bool
    {
        $postDefinedDate  = \Yii::$app->request->post('definedDate');

        $isAjax = \Yii::$app->request->isAjax;

        return $isAjax && !empty($postDefinedDate);
    }

    public static function getCurrentDateTime() : CarbonImmutable
    {
        return CarbonImmutable::now();
    }


}
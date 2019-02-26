<?php

namespace app\support\Timeline;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterval;

class DaysOfMonthPeriod
{

    protected $actualMonth;

    public function __construct()
    {
        $this->actualMonth = CarbonImmutable::now();
    }

    public function lastDayOfMonth() : CarbonImmutable
    {

        return $this->actualMonth->lastOfMonth()->add(CarbonInterval::day(1));
    }

    public function firstDayMonth() : CarbonImmutable
    {
        return $this->actualMonth->firstOfMonth();
    }


}
<?php
namespace app\support\Timeline;

use Carbon\CarbonInterval;

class PickerPeriodMaker
{
    /** @var DaysOfMonthPeriod */
    protected $period;

    /** @var array */
    protected $pickerDays = [];

    /** @var string */
    protected $divider = '|';

    protected function getDaysBetweenTwoDates() : array
    {
        $periodInDays   = new \DatePeriod($this->period->firstDayMonth(), CarbonInterval::day(), $this->period->lastDayOfMonth());

        foreach ($periodInDays as $periodInDay){
            if (! $periodInDay->isWeekend()){
                $this->pickerDays[] = $periodInDay->format('m/d/Y');
            }
        }

        return $this->pickerDays;
    }

    public function makePeriodDays() : string
    {
        return implode($this->divider, $this->getDaysBetweenTwoDates());
    }

    /**
     * @param DaysOfMonthPeriod $period
     */
    public function setPeriod(DaysOfMonthPeriod $period)
    {
        $this->period = $period;
    }

    /**
     * @param string $divider
     */
    public function setDivider(string $divider)
    {
        $this->divider = $divider;
    }


}
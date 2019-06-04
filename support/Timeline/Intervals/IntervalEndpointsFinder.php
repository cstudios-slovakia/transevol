<?php namespace app\support\Timeline\Intervals;

use Carbon\Carbon;

trait IntervalEndpointsFinder
{
    use IntervalHasDifference;

    /** @var Carbon */
    protected $intervalStartsOnHour;

    /** @var Carbon */
    protected $intervalEndsOnHour;



    protected function hasMinutesAbove(Carbon $dateTime) : bool
    {
        return $this->minutesAbove($dateTime) > 0;
    }

    protected function minutesAbove(Carbon $dateTime) : int
    {
        return $dateTime->minute;
    }

    public function intervalTimeUnitAboveValue(string $timeUnit = 'minutes') : int
    {
        return $this->intervalDifference()->{$timeUnit};
    }

    public function hourToStart() : Carbon
    {
        /** @var Carbon $forModify */
        $forModify =     $this->intervalStarts->clone();

        if ($this->hasMinutesAbove($forModify)){
            $minutesAbove = $this->minutesAbove($forModify);

            $forModify->addHour()->subMinutes($minutesAbove);

            return $this->intervalStartsOnHour = $forModify;
        }

        return $this->intervalStartsOnHour = $forModify;
    }

    public function hourToEnd() : Carbon
    {
        /** @var Carbon $forModify */
        $forModify =     $this->intervalEnds->clone();

        if ($this->hasMinutesAbove($forModify)){
            $minutesAbove = $this->minutesAbove($forModify);

            $forModify->subMinutes($minutesAbove);

            return $this->intervalEndsOnHour = $forModify;
        }

        return $this->intervalEndsOnHour = $forModify;
    }
}
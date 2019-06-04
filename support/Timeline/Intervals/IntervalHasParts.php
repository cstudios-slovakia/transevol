<?php namespace app\support\Timeline\Intervals;

use Carbon\Carbon;
use Illuminate\Support\Collection;

trait IntervalHasParts
{
    public function makeIntervalParts() : IntervalPartsBuilderContract
    {
        // predefined endpoints when interval is hourly only
        $middleIntervalStarts   = $this->intervalStarts;
        $middleIntervalEnds     = $this->intervalEnds;

        if ($startHasMinutes =  ! $this->compareTimestamps($this->intervalStarts, $this->intervalStartsOnHour)){
            // there are minutes, it will be new interval based on minutes
            $leftInterval   = new MinutelyTicker($this->intervalStarts, $this->intervalStartsOnHour);

            $this->addIntervalPart('left',$leftInterval);
            // middle interval start changes
            $middleIntervalStarts   = $this->intervalStartsOnHour;
        }

        if ($endHasMinutes = ! $this->compareTimestamps($this->intervalEndsOnHour, $this->intervalEnds)){
            // there are minutes, it will be new interval based on minutes
            $rightInterval   = new MinutelyTicker($this->intervalEndsOnHour, $this->intervalEnds);

            $this->addIntervalPart('right',$rightInterval);
            // middle interval end changes
            $middleIntervalEnds     = $this->intervalEndsOnHour;
        }

        if ($startHasMinutes || $endHasMinutes){
            $middleInterval = new HourlyTicker($middleIntervalStarts, $middleIntervalEnds);

            $this->addIntervalPart('middle',$middleInterval);
        }

        return $this;
    }

    public function addIntervalPart(string $key,$intervalTicker) : IntervalPartsBuilderContract
    {
        $this->intervalParts->put($key,$intervalTicker);

        return $this;
    }

    public function compareTimestamps(Carbon $left, Carbon $right) : bool
    {
        return $left->equalTo($right);
    }

    /**
     * @return Collection
     */
    public function getIntervalParts(): Collection
    {
        return $this->intervalParts;
    }

    public function usedTimeLength() : float
    {
        return $this->intervalParts->sum(function (IntervalTimeUnitTicker $ticker){
            return $ticker->differenceInHours();
        });
    }
}
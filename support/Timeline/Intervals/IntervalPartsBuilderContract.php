<?php namespace app\support\Timeline\Intervals;

use Carbon\Carbon;

interface IntervalPartsBuilderContract
{
    public function makeIntervalParts() : self ;
    public function addIntervalPart(string $key,$intervalTicker) : self;
    public function compareTimestamps(Carbon $left, Carbon $right) : bool;
}
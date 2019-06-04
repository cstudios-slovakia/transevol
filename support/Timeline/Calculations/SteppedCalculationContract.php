<?php namespace  app\support\Timeline\Calculations;

use Illuminate\Support\Collection;

interface SteppedCalculationContract
{
    public static function make($period, float $cost = 0) : SteppedCalculationContract;

    public function calculate() : Collection;
}
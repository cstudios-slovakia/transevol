<?php namespace app\support\StaticCostsCalculators;

interface StaticCostsCalculatorContract
{
    public function cost() : float ;
}
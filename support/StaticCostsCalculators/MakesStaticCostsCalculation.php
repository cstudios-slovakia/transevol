<?php
namespace app\support\StaticCostsCalculators;

use app\support\Converters\StaticCostsUnitConverter;
use app\support\Vehicles\VehicleStaticCostCalculators\MonthlyCostsPerDayCalculator;
use app\support\Vehicles\VehicleStaticCostCalculators\MonthlyCostsPerHourCalculator;
use app\support\Vehicles\VehicleStaticCostCalculators\MonthlyCostsPerMinuteCalculator;
use app\support\Vehicles\VehicleStaticCostCalculators\PeriodCostCalculator;
use app\support\Vehicles\VehicleStaticCostCalculators\VehicleStaticCostsCalculator;
use app\support\Vehicles\VehicleStaticCostCalculators\WorkDayPerHourCalculator;

class MakesStaticCostsCalculation
{
    /** @var array */
    protected $staticCosts;

    /** @var int */
    protected $monthDays;

    /** @var int */
    protected $workDays ;

    public function __construct(array $staticCosts, int $monthDays = 30, int $workDays = 20)
    {
        $this->staticCosts = $staticCosts;
        $this->monthDays    = $monthDays;
        $this->workDays     = $workDays;
    }

    public function makeCalculation() : array
    {
        $monthlyStaticCosts = [];
        $daylyStaticCosts   = [];

        $minutelyCosts   = [];

        foreach ($this->staticCosts as $staticCost){

            $converter  = new StaticCostsUnitConverter();
            $converter->setStaticCosts($staticCost);
            $converter->convert('monthly');



            $month  = new VehicleStaticCostsCalculator();
            $month->setStaticCost($staticCost);
            $month->setConverter($converter);

            $monthlyCostValue  = $month->calculateCost();

            $monthlyStaticCosts[]   = $monthlyCostValue;

            $costPerDayCalculator   = new MonthlyCostsPerDayCalculator();
            $costPerDayCalculator->setDays($this->workDays);
            $costPerDayCalculator->setMonthlyCost($monthlyCostValue);
            $daylyStaticCosts[]     = $costPerDayCalculator->costPerDay();


        }

        $monthCostsSum = array_sum($monthlyStaticCosts);
        $dailyCostsSum = array_sum($daylyStaticCosts);


        // TODO amount days should be dynamic

        $monthlyCostPerHourSumCalculator    = new MonthlyCostsPerHourCalculator($dailyCostsSum);
        $monthlyCostPerHourSum  = $monthlyCostPerHourSumCalculator->costPerHour();

        $workDayCostPerHourCalculator = new WorkDayPerHourCalculator($dailyCostsSum);
        $hourlyWorkCostsSum = $workDayCostPerHourCalculator->costPerHour();

        $minutelyMonthCostsCalculator = new MonthlyCostsPerMinuteCalculator($monthlyCostPerHourSum);
        $minutelyCostsSum = $minutelyMonthCostsCalculator->costPerMinute();

        $minutelyWorkCostsCalculator = new MonthlyCostsPerMinuteCalculator($hourlyWorkCostsSum);
        $minutelyWorkCostsSum = $minutelyWorkCostsCalculator->costPerMinute();


        return [
            'month_days' => $this->monthDays,
            'work_days' => $this->workDays,
            'monthly_costs' => $monthCostsSum,
            'daily_costs' => $dailyCostsSum,
            'hourly_abs_costs' => $monthlyCostPerHourSum,
            'hourly_work_costs' => $hourlyWorkCostsSum,
            'minutely_abs_costs' => $minutelyCostsSum,
            'minutely_work_costs' => $minutelyWorkCostsSum
        ];
    }
}
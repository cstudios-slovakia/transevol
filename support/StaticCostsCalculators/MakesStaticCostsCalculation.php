<?php
namespace app\support\StaticCostsCalculators;

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

            $month  = new MonthlyStaticCostsCalculator();
            $month->setStaticCost($staticCost);
            $monthlyStaticCosts[]   = $month;

            $daylyStaticCostCalculator = new DaylyStaticCostsCalculator();
            $daylyStaticCostCalculator->setStaticCost($staticCost);
            $daylyStaticCosts[] = $daylyStaticCostCalculator;

            $minutelyCostsCalculator = new MinutelyCostsCalculator();
            $minutelyCostsCalculator->setStaticCost($staticCost);
            $minutelyCosts[]    = $minutelyCostsCalculator;

        }
        $monthlyCostsSummarizer     = new CostsSummarizer();
        $monthlyCostsSummarizer->setCountables($monthlyStaticCosts);

        $dailyCostsSummarizer       = new CostsSummarizer();
        $dailyCostsSummarizer->setCountables($daylyStaticCosts);

        $minutelyCostsSummarizer    = new CostsSummarizer();
        $minutelyCostsSummarizer->setCountables($minutelyCosts);

        $monthCostsSum = $monthlyCostsSummarizer->sum();
        $dailyCostsSum = $dailyCostsSummarizer->sum();
        $minutelyCostsSum   = $minutelyCostsSummarizer->sum();

        // TODO amount days should be dynamic
        $hourlyAbsCostsCalculator = new HourlyAbsoluteCostsCalculator(30,$monthCostsSum);
        $hourlyAbsCostsSum = $hourlyAbsCostsCalculator->costResult(true);

        $hourlyWorkCostsCalculator  = new HourlyAbsoluteCostsCalculator(20,$monthCostsSum);
        $hourlyWorkCostsSum = $hourlyWorkCostsCalculator->costResult(true);

        $minutelyWorkCostsCalculator    = new MinutelyWorkCostsCalculator(20, $monthCostsSum);
        $minutelyWorkCostsSum = $minutelyWorkCostsCalculator->costResult(true);

        return [
            'month_days' => $this->monthDays,
            'work_days' => $this->workDays,
            'monthly_costs' => $monthCostsSum,
            'daily_costs' => $dailyCostsSum,
            'hourly_abs_costs' => $hourlyAbsCostsSum,
            'hourly_work_costs' => $hourlyWorkCostsSum,
            'minutely_abs_costs' => $minutelyCostsSum,
            'minutely_work_costs' => $minutelyWorkCostsSum
        ];
    }
}
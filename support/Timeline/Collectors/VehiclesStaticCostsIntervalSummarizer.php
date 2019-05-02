<?php namespace app\support\Timeline\Collectors;

use app\support\StaticCostsCalculators\VehicleStaticCostsSummarizer;

class VehiclesStaticCostsIntervalSummarizer
{
    protected $vehicleCostSummarizers;

    public function __construct()
    {
        $this->vehicleCostSummarizers = collect([]);
    }

    public function addCostsSummarizer(VehicleStaticCostsSummarizer $staticCostsSummarizer) : self
    {
        $this->vehicleCostSummarizers->push($staticCostsSummarizer);

        return $this;
    }

    public function getCostsSum() : array
    {
        $periodSums = [
            'minutely_costs_sum'    => 0,
            'hourly_costs_sum'      => 0,
            'dayly_costs_sum'       => 0,
            'monthly_costs_sum'     => 0,
        ];

        $this->vehicleCostSummarizers->map(function (VehicleStaticCostsSummarizer $summarizer) use (&$periodSums){
            $summarized = $summarizer->summarizedVehicleCosts();

            $periodSums = [
                'minutely_costs_sum'    => $periodSums['minutely_costs_sum'] + $summarized->minutely_costs_sum,
                'hourly_costs_sum'      => $periodSums['hourly_costs_sum'] + $summarized->hourly_costs_sum,
                'dayly_costs_sum'       => $periodSums['dayly_costs_sum'] + $summarized->dayly_costs_sum,
                'monthly_costs_sum'     => $periodSums['monthly_costs_sum'] + $summarized->monthly_costs_sum,
            ];


        });

        return $periodSums;
    }

}
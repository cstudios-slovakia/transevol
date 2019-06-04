<?php namespace app\support\Timeline;

use app\support\Timeline\Calculations\CumulativeCalculation;
use app\support\Timeline\Calculations\PerpetualCalculation;
use app\support\Timeline\Calculations\SteppedCalculationContract;
use app\support\Timeline\Collectors\ChartDataCollector;
use app\support\Timeline\Collectors\TickerCollector;
use app\support\Timeline\Intervals\Knot;
use Illuminate\Support\Collection;

class TimeLineTickerSchema
{
    /**
     * @var Collection
     */
    protected $steps;

    public function __construct()
    {
        $this->steps = collect([]);
    }

    public function makeSteps(Collection $tickers)
    {

        $tickers->each(function (SteppedCalculationContract $ticker, $tickerPartPosition){
            $knot = null;

            if ($tickerPartPosition === 'left'){

                $knot = $this->tickerKnotFromResults($ticker);
//                dd($ticker->position,$ticker);
//                $this->createStep($knot, $tickerPartPosition);

            }

            if ($tickerPartPosition === 'right'){
                $knot = $this->tickerKnotFromResults($ticker);
            }

            if ($tickerPartPosition === 'middle'){
                $ticker->getResult()->each(function ($knot) use ($tickerPartPosition, $ticker){
                    $this->createStep($knot, $ticker, $tickerPartPosition);
                });
            }


            if (isset($knot)) {
                $this->createStep($knot, $ticker, $tickerPartPosition);
            }

        });


    }

    protected function tickerKnotFromResults(SteppedCalculationContract $ticker) : Knot
    {
        $ticks = $ticker->getResult();
        if ($ticker->position === 'right'){
            return $ticks->last();
        }

        return $ticks->first();

    }

    protected function createStep(Knot $knot,SteppedCalculationContract $ticker, string $partPosition = 'middle')
    {
        $step   = new TickerStep($knot, $partPosition);

        $this->steps->push($step);
    }

    public function buildTickerSchema() : array
    {
        $chartable  = $this->getSteps()->groupBy('stepType');
//        dd($chartable);
//        dd($chartable->get('app\models\Calculations\Vehicle\CostPerVehicle'));
        return [
            'timeLine'  => (new TickerCollector())->setTickers($this->getSteps())->mapToJson(),
            'chart'     => (new ChartDataCollector())->setTickers($this->getSteps())->mapToArray(),
//            'chart1'     => (new ChartDataCollector())->setTickers($chartable->get('app\models\Calculations\Vehicle\CostPerVehicle'))->mapToArray(),
//            'chart2'     => (new ChartDataCollector())->setTickers($chartable->get('app\support\Vehicles\VehicleStaticCostsCalculator'))->mapToArray(),
//            'chart3'     => (new ChartDataCollector())->setTickers($chartable->get('app\support\Vehicles\UnusedVehicleStaticCostsCalculator'))->mapToArray(),
        ];
    }

    /**
     * @return Collection
     */
    public function getSteps(): Collection
    {
        return $this->steps;
    }

    public function startStep() : TickerStep
    {
        return $this->steps->filter(function (TickerStep $step){
            if ($step->getPartPosition() === 'left'){
                return $step;
            }
        })->first();
    }

    public function endStep() : TickerStep
    {
        return $this->steps->filter(function (TickerStep $step){
            if ($step->getPartPosition() === 'left'){
                return $step;
            }
        })->last();
    }
}
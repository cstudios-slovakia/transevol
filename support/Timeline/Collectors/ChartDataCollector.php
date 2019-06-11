<?php namespace app\support\Timeline\Collectors;

use app\models\Calculations\Vehicle\CostPerVehicle;
use app\support\Schemas\Charts\CanvasData;
use app\support\Schemas\Charts\CanvasDataOptions;
use app\support\Schemas\Charts\CanvasDataPoint;
use app\support\Schemas\Charts\LineChart;
use app\support\StaticCostsCalculators\GoingsBaseCostCalculator;
use app\support\Timeline\TickerStep;
use app\support\Vehicles\UnusedVehicleStaticCostsCalculator;
use app\support\Vehicles\VehicleStaticCostsCalculator;
use Illuminate\Support\Collection;

class ChartDataCollector extends TickerCollector
{
    public function collectable() : Collection
    {
        $canvasTotalData    = new CanvasData();
        $canvasCostPerVehicleData    = new CanvasData();
        $canvasVehicleStaticCostsData    = new CanvasData();
        $canvasUnusedVehicleStaticCostsData    = new CanvasData();

        $canvasGoingData    = new CanvasData();

        $totalDataOptions   = new CanvasDataOptions();
        $totalDataOptions->name = 'Total';
        $totalDataOptions->color = '#5867dd';
        $totalDataOptions->lineThickness = 5;
        $canvasTotalData->setOptions($totalDataOptions);

        $costPerVehicleOptions   = new CanvasDataOptions();
        $costPerVehicleOptions->name = 'CostPerVehicle';
        $costPerVehicleOptions->color = '#ffb822';
        $costPerVehicleOptions->lineDashType = 'dot';
        $canvasCostPerVehicleData->setOptions($costPerVehicleOptions);

        $vehiclesStaticCostOptions   = new CanvasDataOptions();
        $vehiclesStaticCostOptions->name = 'VehicleStaticCost';
        $vehiclesStaticCostOptions->color = '#34bfa3';
        $vehiclesStaticCostOptions->lineDashType = 'dot';
        $canvasVehicleStaticCostsData->setOptions($vehiclesStaticCostOptions);

        $unusedVehiclesDataOptions   = new CanvasDataOptions();
        $unusedVehiclesDataOptions->name = 'UnusedVehicles';
        $unusedVehiclesDataOptions->color = '#9816f4';
        $unusedVehiclesDataOptions->lineDashType = 'dashDot';
        $canvasUnusedVehicleStaticCostsData->setOptions($unusedVehiclesDataOptions);

        $goingDataOptions   = new CanvasDataOptions();
        $goingDataOptions->name = 'Vykon';
        $goingDataOptions->color = 'red';
        $goingDataOptions->lineThickness = 5;
        $canvasGoingData->setOptions($goingDataOptions);

        $data = $this->tickers->sortBy(function (TickerStep $tickerStep){
            return $tickerStep->getKnot()->getPosition()->timestamp;
        })->groupBy(function (TickerStep $tickerStep) {
            return $tickerStep->getKnot()->getPosition()->timestamp;
        });

//        $data = $this->tickers->groupBy(function(TickerStep $tickerStep){
//            return $tickerStep->getKnot()->getPosition()->timestamp;
//        })

            $data->transform(function ($collection) use ($canvasGoingData, $canvasTotalData, $canvasCostPerVehicleData, $canvasVehicleStaticCostsData, $canvasUnusedVehicleStaticCostsData){

            $valueSum   = $collection->sum(function ($ticker){
                return $ticker->getStepValue(true);
            });

            /** @var Collection $x */
            $x = $collection->groupBy(function (TickerStep $tickerStep){
                return $tickerStep->stepType;
            })->map(function (Collection $collectionByType){
                return $collectionByType->sortBy(function(TickerStep $tickerStep){
                    return $tickerStep->getKnot()->getPosition()->timestamp;
          })->sum(function (TickerStep $tickerStep){
                    return $tickerStep->getStepValue(true);
                });
            });
//            dd($collection);
//            $collection = $collection->sortBy(function(TickerStep $tickerStep){
//                return $tickerStep->getKnot()->getPosition()->timestamp;
//            });

            $ticker     = $collection->last();

            $xCommonAxis    = $ticker->getStepDate()->format('c');

            $canvasTotalDataPoint                       = new CanvasDataPoint(['x' => $xCommonAxis, 'y' => $valueSum]);
            $canvasTotalData->addDataPoints($canvasTotalDataPoint);

            $canvasCostPerVehicleDataPoint              = new CanvasDataPoint(['x' => $xCommonAxis, 'y' => $x->get(CostPerVehicle::class, null)]);
            $canvasCostPerVehicleData->addDataPoints($canvasCostPerVehicleDataPoint);

            $canvasVehicleStaticCostsDataPoint          = new CanvasDataPoint(['x' => $xCommonAxis, 'y' => $x->get(VehicleStaticCostsCalculator::class, null)]);
            $canvasVehicleStaticCostsData->addDataPoints($canvasVehicleStaticCostsDataPoint);

            $canvasUnusedVehicleStaticCostsDataPoint    = new CanvasDataPoint(['x' => $xCommonAxis, 'y' => $x->get(UnusedVehicleStaticCostsCalculator::class, null)]);
            $canvasUnusedVehicleStaticCostsData->addDataPoints($canvasUnusedVehicleStaticCostsDataPoint);

            $canvasGoingDataPoint    = new CanvasDataPoint(['x' => $xCommonAxis, 'y' => $x->get(GoingsBaseCostCalculator::class, null)]);
            $canvasGoingData->addDataPoints($canvasGoingDataPoint);

        });

        $collected  = collect([
            $canvasGoingData->schemaInArray(),
            $canvasTotalData->schemaInArray(),
            $canvasCostPerVehicleData->schemaInArray(),
            $canvasVehicleStaticCostsData->schemaInArray(),
            $canvasUnusedVehicleStaticCostsData->schemaInArray(),
        ]);

        return $collected;
    }

    public function mapToArray()
    {
        return $this->collectable()->toJson();
    }
}
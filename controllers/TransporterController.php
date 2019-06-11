<?php

namespace app\controllers;

use app\models\Calculations\TimeLine\ElementCostCalculator;
use app\models\Calculations\TimeLine\VehicleTimeLineElement;
use app\models\Calculations\Vehicle\CostPerVehicle;
use app\models\TimelineVehicle;
use app\models\Vehicles;
use app\support\helpers\LoggedInUserTrait;
use app\support\Schemas\Charts\CanvasData;
use app\support\Schemas\Charts\CanvasDataPoint;
use app\support\StaticCostsCalculators\CompanyStaticCostsSummarizer;
use app\support\StaticCostsCalculators\GoingsBaseCostCalculator;
use app\support\StaticCostsCalculators\VehicleStaticCostsSummarizer;
use app\support\Timeline\Calculations\CumulativeCalculation;
use app\support\Timeline\Calculations\EfficiencyBaseCalculator;
use app\support\Timeline\Collectors\TickerCollector;
use app\support\Timeline\Collectors\VehiclesStaticCostsIntervalSummarizer;
use app\support\Timeline\Intervals\DailyTicker;
use app\support\Timeline\Intervals\DetectGoingsInInterval;
use app\support\Timeline\Intervals\IntervalBuilder;
use app\support\Timeline\Intervals\IntervalTicker;
use app\support\Timeline\Intervals\IntervalTickersBuilder;

use app\support\Timeline\Intervals\IntervalTimeUnitTicker;
use app\support\Timeline\Intervals\Knot;
use app\support\Timeline\Intervals\MixedIntervalTicker;
use app\support\Timeline\Intervals\PerpetualIntervalTicker;
use app\support\Timeline\TickerStep;
use app\support\Timeline\TimeLineCostsBuilder;
use app\support\Timeline\TimeLineDataBuilder;
use app\support\Timeline\TimeLineTickerSchema;
use app\support\Timeline\TimeLineVehicleBuilder;
use app\support\Timeline\Units\Goings\GoingTimeLineElement;
use app\support\Timeline\Vehicles\UnusedVehiclesInInterval;
use app\support\Timeline\Vehicles\VehicleSeparatorInTimeLine;
use app\support\Transporter\DetectVehiclesInInterval;

use app\support\Vehicles\UnusedVehicleStaticCostsCalculator;
use app\support\Vehicles\VehicleStaticCostsCalculator;
use Carbon\Carbon;

use app\controllers\api\v1\BaseAjaxController;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use Spatie\Period\Period;
use Spatie\Period\PeriodCollection;
use Spatie\Period\Precision;


class TransporterController extends BaseAjaxController
{
    use LoggedInUserTrait;

    public function actionDev()
    {



        $company    = $this->loggedInUserCompany();
        $vehicle    = Vehicles::findOne(1);
        $intervalStart  = Carbon::create(2019,4,10,4,30);
        $intervalEnd    = Carbon::create(2019,4,10,22,45);



        ///////////////////////////

        $intervalTickerBuilder = new IntervalTickersBuilder($intervalStart, $intervalEnd);

        $companyCostsSummarizer     = new CompanyStaticCostsSummarizer();
        $companyCostsSummarizer->setCompanyId($company->id);


        $vehiclesInIntervalDetector     = new \app\support\Timeline\Vehicles\DetectVehiclesInInterval();
        $vehiclesInIntervalDetector
            ->setIntervalStart($intervalStart)
            ->setIntervalEnd($intervalEnd)
            ->setVehicle($vehicle);

        $costPerVehicleCalculator  = new CostPerVehicle();
        $costPerVehicleCalculator
            ->setCompanyStaticCost($companyCostsSummarizer)
            ->setVehiclesInIntervalDetector($vehiclesInIntervalDetector);



        $mainVehicleStaticCostsSummarizer = new VehicleStaticCostsSummarizer();
        $mainVehicleStaticCostsSummarizer->setVehicleId($vehicle->id);

        $vehicleStaticCostsCalculator   = new VehicleStaticCostsCalculator();
        $vehicleStaticCostsCalculator->setVehicleStaticCostsSummarizer($mainVehicleStaticCostsSummarizer);




        $intervalParts = $intervalTickerBuilder->getIntervalParts();

        $intervalTicker = new IntervalTicker();
        $intervalTicker->parts  = $intervalParts;
        $intervalTicker->costCalculator = $costPerVehicleCalculator;

        $vehicleIntervalTicker  = new IntervalTicker();
        $vehicleIntervalTicker->parts = $intervalParts;
        $vehicleIntervalTicker->costCalculator = $vehicleStaticCostsCalculator;

        $tickerSchemaBuilder    = new TimeLineTickerSchema();
        $tickerSchemaBuilder->makeSteps($intervalTicker->tick()->getTickers());
        $tickerSchemaBuilder->makeSteps($vehicleIntervalTicker->tick()->getTickers());



        $vehicleSeparator = new VehicleSeparatorInTimeLine($vehiclesInIntervalDetector);

        $unusedVehiclesData = $vehicleSeparator->getUnusedVehiclesData();

        $unusedVehicleTickerSchemaBuilder    = new TimeLineTickerSchema();



        $unusedVehiclesData->map(function($unusedVehicleData) use ($vehiclesInIntervalDetector, $tickerSchemaBuilder, $unusedVehicleTickerSchemaBuilder){
            $vehicleId  = $unusedVehicleData['checkedVehicle']->vehicle_id;
            $unusedVehicleStaticCostsSummarizer = new VehicleStaticCostsSummarizer();
            $unusedVehicleStaticCostsSummarizer->setVehicleId($vehicleId);

            $unusedVehicleStaticCostsCalculator   = new UnusedVehicleStaticCostsCalculator();
            $unusedVehicleStaticCostsCalculator->mainVehiclesAmount     = $vehiclesInIntervalDetector->mainVehiclesCounter();
//            dd($unusedVehicleStaticCostsSummarizer->summarizedVehicleCosts());
            $unusedVehicleStaticCostsCalculator->setVehicleStaticCostsSummarizer($unusedVehicleStaticCostsSummarizer);

            foreach ($unusedVehicleData['tickers'] as $ticker) {


                $intervalTicker = new PerpetualIntervalTicker();
                $intervalTicker->parts          = $ticker->getIntervalParts();
                $intervalTicker->costCalculator = $unusedVehicleStaticCostsCalculator;

//                $unusedVehicleTickerSchemaBuilder->makeSteps($intervalTicker->tick()->getTickers());
                $tickerSchemaBuilder->makeSteps($intervalTicker->tick()->getTickers());
            }

        });

        $tickableSchemas = $tickerSchemaBuilder->buildTickerSchema();

        /** @var TickerCollector $tickerController */
        $tickerCollector   = $tickerSchemaBuilder->collectors()->get('tickerCollector');

        $efficiencyCalculator =    EfficiencyBaseCalculator::make($tickerCollector->getMaxValue(), $intervalTickerBuilder);

        $baseEfficiency     = $efficiencyCalculator->getBaseEfficiencyValue();
        $usedTime           = $efficiencyCalculator->getUsedTime();

        $xGoingBaseCostCalculator = new GoingsBaseCostCalculator();
        $xGoingBaseCostCalculator->baseCost = $baseEfficiency;


        $goingIntervalDetector     = new DetectGoingsInInterval();
        $goingIntervalDetector->setIntervalStarts($intervalStart);
        $goingIntervalDetector->setIntervalEnds($intervalEnd);
        $goings = $goingIntervalDetector->setVehicle($vehicle);
        $x = $goings->detect();
        $format     = 'Y-m-d H:i:s';
        $goingTimeLineElementsPlacedOnMainInterval  = $x->map(function (GoingTimeLineElement $goingTimeLineElement) use ($format){

            return Period::make($goingTimeLineElement->formatted('startAttribute',$format), $goingTimeLineElement->formatted('endAttribute',$format),Precision::MINUTE);
        })->toArray();





        $mainIntervalPeriod = Period::make($goingIntervalDetector->formatted('getIntervalStarts',$format),$goingIntervalDetector->formatted('getIntervalEnds',$format),Precision::MINUTE);
        $goingsOverlapsMainInterval = call_user_func_array([$mainIntervalPeriod,'overlap'], $goingTimeLineElementsPlacedOnMainInterval);

        $goingsOverlapsMainInterval->map(function (Period $period){
            $period->type   = 'overlap';
            $period->startedAt = $period->getStart()->getTimestamp();
            return $period;
        });


        $goingsDiffsOnMainInterval = call_user_func_array([$mainIntervalPeriod,'diff'], $goingTimeLineElementsPlacedOnMainInterval);

        $goingsDiffsOnMainInterval->map(function (Period $period){
            $period->type   = 'diff';
            $period->startedAt = $period->getStart()->getTimestamp();
            return $period;
        });

        $goingsOnMainInterval = collect($goingsOverlapsMainInterval)->merge($goingsDiffsOnMainInterval);



        $zTickerSchemaBuilder    = new TimeLineTickerSchema();

        $starterValue   = 0;
//        dd($goingsOnMainInterval);
        $goingsOnMainIntervalSortedByTime = $goingsOnMainInterval->sortBy(function (Period $goingPeriod){

            return $goingPeriod->getStart()->getTimestamp();
        })->values()->map(function(Period $goingPeriod) use ($xGoingBaseCostCalculator, $zTickerSchemaBuilder, &$starterValue){

            $goingsIntervalTickerBuilder    =  new IntervalTickersBuilder(Carbon::createFromTimestamp($goingPeriod->getStart()->getTimestamp()), Carbon::createFromTimestamp($goingPeriod->getEnd()->getTimestamp()));
            $parts  = $goingsIntervalTickerBuilder->getIntervalParts();
            $mixedIntervalTicker    = new MixedIntervalTicker();
            $mixedIntervalTicker->parts     = $parts;
            $mixedIntervalTicker->costCalculator = $xGoingBaseCostCalculator;
            $mixedIntervalTicker->periodType = $goingPeriod->type;

            $mixedIntervalTicker->setTickStartValue($starterValue);
            $mixedIntervalTicker->tick();
            $starterValue = $mixedIntervalTicker->getLastKnotValue();
//            var_dump($starterValue);


            $zTickerSchemaBuilder->makeSteps($mixedIntervalTicker->getTickers());
        });
//        dd( $zTickerSchemaBuilder->getSteps()->keyBy(function (TickerStep $tickerStep){
//            return $tickerStep->getStepDate()->format('Y-m-d H:i');
//        })->map(function (TickerStep $tickerStep){
//            return $tickerStep->getStepValue();
//        }) );
//        foreach ($goingsOnMainInterval as $goingOnMainInterval){
//            $goingsIntervalTickerBuilder    =  new IntervalTickersBuilder(Carbon::createFromTimestamp($goingOnMainInterval->getStart()->getTimestamp()), Carbon::createFromTimestamp($goingOnMainInterval->getEnd()->getTimestamp()));
//            dd($goingsIntervalTickerBuilder->getIntervalParts());
//            $mixedIntervalTicker    = new MixedIntervalTicker();
//
//        }
//
//        dd($goingsOnMainInterval,$goingsOverlapsMainInterval, $goingsDiffsOnMainInterval);
//


        $goingsCollectionForIntervalTickers = collect([]);

        $xxx = [];

//        /** @var PeriodCollection $f */
//        $f->map(function (Period $goingPeriods){
//            $goingPeriods->startedAt = $goingPeriods->getStart();
//
//            return $goingPeriods;
//        });
//        $w = collect($f)->sortBy(function(Period $period){
//            return $period->getStart()->getTimestamp();
//        });
//
//
//
//        foreach ($w as $period){
//            /** @var Period $period */
//            $xIntTickerBuilder  = new IntervalTickersBuilder(Carbon::createFromTimestamp($period->getStart()->getTimestamp()), Carbon::createFromTimestamp($period->getEnd()->getTimestamp()));
//            $c = $xIntTickerBuilder->getIntervalParts();
//
//            $c->each(function (IntervalTimeUnitTicker $ticker,string $partPosition) use ($mixedIntervalTicker){
//                $mixedIntervalTicker->addPart($partPosition, $ticker);
//
//            });
//
//            $xIntTicker     = new IntervalTicker();
//            $xIntTicker->parts  = $c;
//            $xIntTicker->costCalculator = $xGoingBaseCostCalculator;
//
//            $xIntTicker->tick();
//
//            $xxx[] = $xIntTicker;
//
//            $b = $xIntTicker->tick()->getTickers();
//
//
//            $goingsCollectionForIntervalTickers->push($b);
////            dd($b);
//            $zTickerSchemaBuilder->makeSteps($b);
//        }
//        dd($mixedIntervalTicker,$goingsCollectionForIntervalTickers,$xxx);
//
//        $goingsOverSelectedInterval     = new IntervalTickersBuilder();

//        dd($goingIntervalDetector);

//dd($zTickerSchemaBuilder);
//
        $zTickerSchema = $zTickerSchemaBuilder->buildTickerSchema();
        $tickableSchemas['going']   = $zTickerSchema['timeLine'];
//dd($tickableSchemas['chart']->merge($zTickerSchema['chart']));
        $tickableSchemas['chart']   = $tickableSchemas['chart']->merge($zTickerSchema['chart'])->toJson();
//        dd($tickableSchemas);



//
//            dd($f, $zTickerSchemaBuilder);
//
//        dd($x, $y,$f);
//        dd();

        return [
//            'perVehicleSchema' => [],
            'tickersData' => $tickableSchemas,
            'helpers'   => [
                'baseEfficiency'    => $baseEfficiency,
                'usedTime'          => $usedTime
            ]
//            'unusedVehicleSchema'   => $tickerCollection->mapToJson()
        ];
//        dd($vehicleByTimeUnit);
        return $this->render('dev',[
            'perVehicleSchema' => $byTimeUnit,
            'vehicleSchema' => $vehicleByTimeUnit,
            'unusedVehicleSchema'   => $unusedVehicleByTimeUnit
        ]);




    }

    public function actionViewer()
    {

//        $isAjax = $this->checkIsAjaxRequest();

        $timeLineDataBuilder = new TimeLineDataBuilder();
//
//        if ($isAjax){
//
//            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//
//            return $timeLineDataBuilder->renderableData();
//        }


        return $this->render('viewer', $timeLineDataBuilder->renderableData());
    }

    protected function viewerRedirector(array $params)
    {
        $route = ['/transporter/viewer'];

        return $this->redirect(\yii\helpers\Url::toRoute(array_merge($route,$params)));
    }


}

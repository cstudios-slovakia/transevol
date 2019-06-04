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
use app\support\StaticCostsCalculators\VehicleStaticCostsSummarizer;
use app\support\Timeline\Calculations\CumulativeCalculation;
use app\support\Timeline\Collectors\TickerCollector;
use app\support\Timeline\Collectors\VehiclesStaticCostsIntervalSummarizer;
use app\support\Timeline\Intervals\DailyTicker;
use app\support\Timeline\Intervals\IntervalBuilder;
use app\support\Timeline\Intervals\IntervalTicker;
use app\support\Timeline\Intervals\IntervalTickersBuilder;

use app\support\Timeline\Intervals\Knot;
use app\support\Timeline\Intervals\PerpetualIntervalTicker;
use app\support\Timeline\TickerStep;
use app\support\Timeline\TimeLineCostsBuilder;
use app\support\Timeline\TimeLineDataBuilder;
use app\support\Timeline\TimeLineTickerSchema;
use app\support\Timeline\TimeLineVehicleBuilder;
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


class TransporterController extends BaseAjaxController
{
    use LoggedInUserTrait;

    public function actionDev()
    {



         $company    = $this->loggedInUserCompany();
        $vehicle    = Vehicles::findOne(1);
        $intervalStart  = Carbon::create(2019,4,10,4,30);
        $intervalEnd    = Carbon::create(2019,4,10,9,45);


//        $canvasData = new CanvasData();
//
//        $canvasDataPoint = new CanvasDataPoint(['index' => $intervalStart,$company]);
//
//        $xt = $canvasDataPoint->getAttribute('index');
//
//        dd($canvasData,$canvasDataPoint ,$xt);

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


//        dd($tickerSchemaBuilder->buildTickerSchema());

//        $pervehicleCollection   = new TickerCollector();
//        $pervehicleCollection->setTickers($vehicleByTimeUnit);

        return [
//            'perVehicleSchema' => [],
            'tickersData' => $tickerSchemaBuilder->buildTickerSchema(),
//            'unusedVehicleSchema'   => $tickerCollection->mapToJson()
        ];
        dd($vehicleByTimeUnit);
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

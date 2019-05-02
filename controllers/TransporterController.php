<?php

namespace app\controllers;

use app\models\Calculations\TimeLine\ElementCostCalculator;
use app\models\Calculations\TimeLine\VehicleTimeLineElement;
use app\models\Calculations\Vehicle\CostPerVehicle;
use app\models\Vehicles;
use app\support\helpers\LoggedInUserTrait;
use app\support\StaticCostsCalculators\CompanyStaticCostsSummarizer;
use app\support\StaticCostsCalculators\VehicleStaticCostsSummarizer;
use app\support\Timeline\Collectors\VehiclesStaticCostsIntervalSummarizer;
use app\support\Timeline\Intervals\DailyTicker;
use app\support\Timeline\Intervals\IntervalTicker;

use app\support\Timeline\TimeLineCostsBuilder;
use app\support\Timeline\TimeLineDataBuilder;
use app\support\Timeline\TimeLineVehicleBuilder;
use app\support\Timeline\Vehicles\VehicleSeparatorInTimeLine;
use app\support\Transporter\DetectVehiclesInInterval;

use Carbon\Carbon;

use app\controllers\api\v1\BaseAjaxController;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;

class TransporterController extends BaseAjaxController
{
    use LoggedInUserTrait;

    public function actionDev()
    {
        $bintervalStart  = Carbon::create(2019,4,10,13,50);
        $bintervalEnd    = Carbon::create(2019,4,10,18,20);

        $period = CarbonPeriod::create($bintervalStart, $bintervalEnd)
            ->setDateInterval(CarbonInterval::hour(1));

        dd($period);
        $intervalStart  = Carbon::create(2019,4,10,0,0);
        $intervalEnd    = Carbon::create(2019,4,11,0,0);
        $vehicle    = Vehicles::findOne(1);

        $company    = $this->loggedInUserCompany();


        $companyCostsSummarizer     = new CompanyStaticCostsSummarizer();
        $companyCostsSummarizer->setCompanyId($company->id);


        $intervalTicker = new IntervalTicker($intervalStart, $intervalEnd);
        $dailyTicker = new DailyTicker($intervalStart,$intervalEnd);

        $vehiclesInIntervalDetector     = new \app\support\Timeline\Vehicles\DetectVehiclesInInterval();
        $vehiclesInIntervalDetector
            ->setIntervalStart($intervalStart)
            ->setIntervalEnd($intervalEnd)
            ->setVehicle($vehicle);

        $costPerVehicleCalculator  = new CostPerVehicle();
        $costPerVehicleCalculator
            ->setCompanyStaticCost($companyCostsSummarizer)
            ->setVehiclesInIntervalDetector($vehiclesInIntervalDetector);
        $costPerMainVehicle = $costPerVehicleCalculator->cost();

        $x  = new TimeLineCostsBuilder();
        $x->setPeriodic($dailyTicker);
        $x->addDefaultCost('perVehicle', $costPerVehicleCalculator);
        $x->build();
        dd($x);
        $cB     = collect($x->getPeriodicallyCosts())->keyBy(function($periodCost){
            dd($periodCost,2);
        });

        dd($cB);


        dd($costPerVehicleCalculator->cost());

        $vehicleSeparator = new VehicleSeparatorInTimeLine($vehiclesInIntervalDetector);

        $unusedVehicleIds   = $vehicleSeparator->getUnusedVehicleIds();

        $vehicleStaticCostsIntervalSummarizer = new VehiclesStaticCostsIntervalSummarizer();

        foreach ($unusedVehicleIds as $vehicleId){
            $vehicleStaticCostsSummarizer   = new VehicleStaticCostsSummarizer();
            $vehicleStaticCostsSummarizer->setVehicleId($vehicleId);

            $vehicleStaticCostsIntervalSummarizer->addCostsSummarizer($vehicleStaticCostsSummarizer);
        }

        $unusedVehiclesCosts    = $vehicleStaticCostsIntervalSummarizer->getCostsSum();

        $detectedVehiclesInInterval     = $vehiclesInIntervalDetector->getDetectedVehicles();


        $x  = $detectedVehiclesInInterval->transform(function($element) {

            $elementCostCalculator  = new ElementCostCalculator($element);

            if($element instanceof VehicleTimeLineElement){
                $elementClass = VehicleTimeLineElement::class;
            }

            return [
                'element_id'    => $element->id,
                'type'    => get_class($element),
//                'type'    => get_class($element),
                'type_id'   => function(){
                    return $this->element->vehicle_id;
                },
                'element'   => $element,
                'element_costs'  => $elementCostCalculator,
//                'overlaps'  => $interval
            ];

        });



        dd($x);

        dd($unusedVehiclesCosts,$vehiclesInIntervalDetector->getDetectedVehicles());

        $vehiclesOnMove   = collect($vehiclesInIntervalDetector->detect());

        $x = $vehiclesOnMove->pluck('vehicle_id')->unique();

        dd($x,$vehiclesInIntervalDetector->detect());

//        $year   = 2019;
//
//        $seekedYearBegins = Carbon::create($year);
//        $seekedYearEnds =  Carbon::create($year.'-12-31');
////        $seekedYearBegins = Carbon::now()->year($year)->startOfYear();
////        $seekedYearEnds = Carbon::now()->year($year)->endOfYear();
////        $seekedYearEnds = Carbon::now()->year($year)->month(12)->day(31)->hour(24)->minutes(0);
//
//        $seekedYearDiff = $seekedYearBegins->floatDiffInRealDays($seekedYearEnds);
//
//        $year2016   = Carbon::create(2016)->daysInYear * 1440;
//        $year2019   = Carbon::create(2019)->daysInYear * 1440;
//
//        dd($year2019, $year2016);
//
//        dd();

        $vehicleStaticCostsSummarizer   = new VehicleStaticCostsSummarizer();
        $vehicleStaticCostsSummarizer->setVehicleId(8);
        dd($vehicleStaticCostsSummarizer->summarizedVehicleCosts());


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

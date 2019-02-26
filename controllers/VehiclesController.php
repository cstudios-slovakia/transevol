<?php

namespace app\controllers;

use app\models\Companies;
use app\models\VehicleStaticCost;
use app\models\VehicleStaticCosts;
use app\models\VehicleStaticCostsForm;
use app\support\Converters\BusinessDays;
use app\support\FrequencyDataBuilder;
use app\support\helpers\LoggedInUserTrait;
use app\support\StaticCostsCalculators\CostsSummarizer;
use app\support\StaticCostsCalculators\DaylyGoingsCalculator;
use app\support\StaticCostsCalculators\DaylyStaticCosts;
use app\support\StaticCostsCalculators\DaylyStaticCostsCalculator;
use app\support\StaticCostsCalculators\HourlyAbsoluteCostsCalculator;
use app\support\StaticCostsCalculators\HourlyCostCalculator;
use app\support\StaticCostsCalculators\MakesStaticCostsCalculation;
use app\support\StaticCostsCalculators\MinutelyCostsCalculator;
use app\support\StaticCostsCalculators\MinutelyWorkCostsCalculator;
use app\support\StaticCostsCalculators\MonthlyStaticCosts;
use app\support\StaticCostsCalculators\MonthlyStaticCostsCalculator;
use app\support\Timeline\DaysOfMonthPeriod;
use app\support\Timeline\PickerPeriodMaker;
use app\support\Vehicles\Relations\RelationAssistance;
use app\support\Vehicles\Relations\VehicleRelationAssistance;
use app\support\Vehicles\VehicleStaticCostCalculators\PeriodCostCalculator;
use app\support\Vehicles\VehicleStaticCostCalculators\VehicleStaticCostsCalculator;
use Illuminate\Support\Carbon;
use Yii;
use app\models\Vehicles;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Expression;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\support\Converters\StaticCostsUnitConverter;
use yii\web\Response;

/**
 * VehiclesController implements the CRUD actions for Vehicles model.
 */
class VehiclesController extends BaseController
{
    use LoggedInUserTrait;
    /**
     * {@inheritdoc}
     */


    /**
     * Lists all Vehicles models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Vehicles::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Vehicles model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $vehicleStaticCostFormModel  = new VehicleStaticCostsForm();
        $associatedStaticCosts  = collect($model->vehicleStaticCosts)->keyBy(function ($vehicleStaticCost){
            return $vehicleStaticCost->staticCosts->short_name;
        });

        $loadable = $associatedStaticCosts->transform(function($vehicleStaticCosts){
            return $vehicleStaticCosts->value;
        })->toArray();

        $vehicleStaticCostFormModel->load($loadable,'');

        return $this->render('view', [
            'model' => $model,
            'vehicleStaticCostFormModel'    => $vehicleStaticCostFormModel
        ]);
    }

    /**
     * Creates a new Vehicles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Vehicles();
        $vehicleStaticCostFormModel  = new VehicleStaticCostsForm();

        $request = Yii::$app->request;



        $staticCosts = VehicleStaticCost::find()->all();
        $staticCostsCollection = collect($staticCosts)->keyBy('short_name');

        if ($model->load($request->post(),'Vehicles') && $vehicleStaticCostFormModel->load($request->post(),'StaticCostsForm')) {
            $company    = self::loggedInUserCompany();

            $model->companies_id = $company->id;

            $validVehicle = $model->validate();
            $validVehicleStaticCosts = $vehicleStaticCostFormModel->validate();

            if ($validVehicle && $validVehicleStaticCosts){

                $model->save();

                $staticCostInputs = $request->post()['StaticCostsForm'];

                foreach ($staticCostInputs as $shortName => $staticCostInput){
                    $vehicleStaticCost = new VehicleStaticCosts();
                    $vehicleStaticCost->value   = $staticCostInput['value'];
                    $vehicleStaticCost->vehicles_id     = $model->id;
                    $vehicleStaticCost->frequency_datas_id = $staticCostInput['frequency_datas_id'];
                    $vehicleStaticCost->link('staticCosts', $staticCostsCollection->get($shortName));
                    $vehicleStaticCost->save();
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }

        }



        return $this->render('create', [
            'model'             => $model,
            'vehicleStaticCostFormModel' => $vehicleStaticCostFormModel,
            'staticCostsCollection'    => $staticCostsCollection,
            'costs' => collect($staticCosts)
        ]);

    }

    /**
     * Updates an existing Vehicles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $vehicleStaticCostFormModel  = new VehicleStaticCostsForm();

        $request = Yii::$app->request;

        $staticCosts = VehicleStaticCost::find()->all();
        $staticCostsCollection = collect($staticCosts)->keyBy('short_name');

        $associatedStaticCosts  = collect($model->vehicleStaticCosts)->keyBy(function ($vehicleStaticCost){
            return $vehicleStaticCost->staticCosts->short_name;
        });

        if ($model->load($request->post(),'Vehicles') && $vehicleStaticCostFormModel->load($request->post(),'StaticCostsForm')) {

            $validModel = $model->validate();
            $validStaticCosts  = $vehicleStaticCostFormModel->validate();

            if($validModel && $validStaticCosts){
                $model->update();

                $staticCostInputs = $request->post()['StaticCostsForm'];

                foreach ($associatedStaticCosts as $shortName => $vehicleStaticCost){

                    $vehicleStaticCost->value   = $staticCostInputs[$shortName]['value'];
                    $vehicleStaticCost->frequency_datas_id   = $staticCostInputs[$shortName]['frequency_datas_id'];
                    $vehicleStaticCost->update();
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }


        }

        $loadable = $associatedStaticCosts->transform(function($vehicleStaticCosts){
            return $vehicleStaticCosts->value;
        })->toArray();

//         $vehicleStaticCostFormModel->load($loadable,'');


        return $this->render('update', [
            'model'             => $model,
            'vehicleStaticCostFormModel' => $vehicleStaticCostFormModel,
            'staticCostsCollection'    => $staticCostsCollection,
            'costs' => collect($staticCosts)
        ]);
    }

    /**
     * Deletes an existing Vehicles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Vehicles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Vehicles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Vehicles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionStatisticsIndex()
    {

        $workDaysInput = [];
        $workDays = collect($workDaysInput);

        if ($ajax = Yii::$app->request->isAjax){
            // get the ajax post
            $workDaysInput = Yii::$app->request->post('input');

            // map over the items
            $workDays = collect($workDaysInput)
                ->map(function ($record){

                    $identification = $record['identification'];

                    $re = '/^work_days\[(.*?)\]/';
                    $str = $identification;

                    preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);

                    $recordId   = preg_replace('/\D/','',$identification);
                    $recordType = $matches[0][1];

                    $record['type'] = $recordType;
                    $record['id'] = $recordId;

                    // change record and populate with id and type
                    return $record;
                })
                // simply sort by type for easier search
                ->groupBy('type');

        }


        $mainVehicleShortName = Vehicles::MAIN_VEHICLE_SHORT_NAME;

        $vehicles = Vehicles::find()
            ->with('vehicleStaticCosts')
            ->with('vehicleTypes')
            ->with('vehicleStaticCosts.frequencyData')->all();


        $mainVehicleRecords = [];
        $notMainVehicleRecords = [];
        $choosedWorkDatesOnVehicles = '';
        foreach ($vehicles as $vehicle) {
            $wd = 20;

            $daysOfMonth = new DaysOfMonthPeriod();

            $pickerPeriodMaker = new PickerPeriodMaker();
            $pickerPeriodMaker->setPeriod($daysOfMonth);
            $pickerBusinessDays  = $pickerPeriodMaker->makePeriodDays();

            // check input contains main vehicle
            if($workDays->has('main_vehicle')){
                // sort vehicle data by ID
                $mainVehicleInputs = collect($workDays->get('main_vehicle'))->keyBy('id');

                // change work days number if exists
                if ($mainVehicleInputs->has($vehicle->id)){
                    $choosedWorkDatesOnMainVehicles   = $mainVehicleInputs->get($vehicle->id)['workDates'];
                    $choosedWorkDatesOnMainVehiclesExploded   = explode('|',$choosedWorkDatesOnMainVehicles);
                    $wd = (int) count($choosedWorkDatesOnMainVehiclesExploded);
                }
            }

            // check input contains main vehicle
            if($workDays->has('not_main_vehicle')){
                // sort vehicle data by ID
                $notMainVehicleInputs = collect($workDays->get('not_main_vehicle'))->keyBy('id');

                // change work days number if exists
                if ($notMainVehicleInputs->has($vehicle->id)){
                    $choosedWorkDatesOnVehicles = $notMainVehicleInputs->get($vehicle->id)['workDates'];
                    $choosedWorkDatesOnVehiclesExploded = explode('|', $choosedWorkDatesOnVehicles);
                    $wd = (int) count($choosedWorkDatesOnVehiclesExploded);
                }
            }

            $statistics = $this->oneVehicleStatistics($vehicle->id, $vehicle, ['work_days' => $wd] );
            $statistics['statistics']['work_days']=  $choosedWorkDatesOnVehicles;
//            var_dump($statistics);
            $record     = array_merge(['ecv' => $vehicle->ecv,'id'=> $vehicle->id, 'specified_work_dates' => $pickerBusinessDays], $statistics['statistics']);

            // split not main vehicles into another collection
            if ($vehicle->vehicleTypes->type_shortly === $mainVehicleShortName){
                $mainVehicleRecords[] = $record;
            } else{
                $notMainVehicleRecords[]    = $record;
            }

        }


        $mainVehicleDataProvider = new ArrayDataProvider([
            'allModels' => $mainVehicleRecords
        ]);

        $notMainVehicleDataProvider     = new ArrayDataProvider([
            'allModels' => $notMainVehicleRecords
        ]);

        // we need to calculate company static costs too
        // define some defaults
        $wd = 20;
        $monthDays = 30;

        // company is logged in, grab it
        $company = LoggedInUserTrait::loggedInUserCompany();

        if($workDays->has('company_data')){
            // sort vehicle data by ID
            $companyDatas = collect($workDays->get('company_data'))->keyBy('id');

            // change work days number if exists
            if ($companyDatas->has($company->id)){
                $choosedWorkDatesOnCompany = explode('|',$companyDatas->get($company->id)['workDates']);
                $wd = (int) count($choosedWorkDatesOnCompany);
            }
        }

        // query for company costs
        $companyStaticCosts    = $company->getCompanyCostDatas()
            ->with('staticCosts')
            ->joinWith('staticCosts')
            ->with('frequencyData')
            ->all();

        // calculate static costs with calculator
        $companyStaticCostsCalculator = new MakesStaticCostsCalculation($companyStaticCosts, $monthDays, $wd);

        $companyStatistics = $companyStaticCostsCalculator->makeCalculation();


        $companyStatistics['col_name']   = 'Administratívne náklady';
        $companyStatistics['id']   = $company->id;
        $companyStatistics['specified_work_dates']   = $pickerBusinessDays;

        // amount of main vehicles
        $mainVehicleAmount = (int) $mainVehicleDataProvider->getTotalCount();

        // one company has one collection of static costs
        $companyCostsDividedIntoMainVehicles = [];
        $companyCostsDividedIntoMainVehicles['col_name']    = 'Per vozidlo';

        // we are interested in costs only
        foreach ($companyStatistics as $columnName => $columnValue){
            if(str_contains($columnName,'costs')){
                $companyCostsDividedIntoMainVehicles[$columnName] =  $columnValue / $mainVehicleAmount;
            }
        }

        $companyCostsDividedIntoAddedVehicles = [];
        $companyCostsDividedIntoAddedVehicles['col_name']    = 'Na vozidlo s privesom';

        // we have to sum added vehicles all types of costs
        $addedVehiclesCollection    = collect($notMainVehicleRecords);

        foreach ($companyCostsDividedIntoMainVehicles as $columnName => $columnValue){
            if(str_contains($columnName,'costs')){
                $companyCostsDividedIntoAddedVehicles[$columnName] =  ($columnValue + $addedVehiclesCollection->sum($columnName)) / $mainVehicleAmount;
            }
        }

        $companyDataProvider    = new ArrayDataProvider([
            'allModels' => [$companyStatistics,$companyCostsDividedIntoMainVehicles, $companyCostsDividedIntoAddedVehicles]

        ]);


        // we have re-calculate main vehicles cost because of added vehicles
        $reCalculatedMainVehicleRecords = [];
        foreach ($mainVehicleRecords as $mainVehicleRecord){

            $record = [];
            foreach ($mainVehicleRecord as $costName => $costValue){
                if(str_contains($costName,'costs')){
                    $record[$costName] =  $companyCostsDividedIntoAddedVehicles[$costName] + $costValue;
                } else{
                    $record[$costName] = $costValue;
                }
            }

            $reCalculatedMainVehicleRecords[] = $record;
        }
    ;


        $reCalculatedMainVehicleDataProvider = new ArrayDataProvider([
            'allModels' => $reCalculatedMainVehicleRecords
        ]);

        $providers  = [
            'mainVehicleDataProvider' => $mainVehicleDataProvider,
            'notMainVehicleDataProvider' => $notMainVehicleDataProvider,
            'companyDataProvider' => $companyDataProvider,
            'reCalculatedMainVehicleDataProvider'   => $reCalculatedMainVehicleDataProvider
        ];

        if ($ajax = Yii::$app->request->isAjax) {

            $response   = [
                'status'    => 'ok',
                'data'      => [
                    'mainVehicleDataProvider' => $this->renderPartial('statistics/_partial/main_vehicle_grid',['mainVehicleDataProvider' => $providers['mainVehicleDataProvider']]),
                    'notMainVehicleDataProvider' => $this->renderPartial('statistics/_partial/not_main_vehicle_grid',['notMainVehicleDataProvider' => $providers['notMainVehicleDataProvider']]),
                    'companyDataProvider' => $this->renderPartial('statistics/_partial/company_data_grid',['companyDataProvider'  => $providers['companyDataProvider']]),
                    'reCalculatedMainVehicleDataProvider'   => $this->renderPartial('statistics/_partial/recalculated_main_vehicle_grid',['reCalculatedMainVehicleDataProvider'  => $providers['reCalculatedMainVehicleDataProvider']]),
                ],
                'request'   => $workDaysInput
            ];

            Yii::$app->response->format = Response::FORMAT_JSON;
            return  $response;
        }

//        $businessDays = new BusinessDays();
//        $businessDaysInMonth = $businessDays->daysBetween($firstDayOfMonth->toMutable(),$lastDayOfMonth->toMutable());





//        dd($pickerPeriodMaker,$pickerBusinessDays);


        return $this->render('statistics/index', $providers);
    }

    public function actionStatistics(int $id)
    {

        return $this->render('statistics/show',$this->oneVehicleStatistics($id));

    }


    public function oneVehicleStatistics(int $id, Model $model = null,array $options = [])
    {
        $workDays = 20;
        $monthDays = 30;

        if (!empty($options) && array_key_exists('work_days',$options)){
            $workDays   = $options['work_days'];
        }

        if (!empty($options) && array_key_exists('month_days',$options)){
            $monthDays   = $options['month_days'];
        }

        if (!$model){
            $model = $this->findModel($id);
        }

        $staticCosts = $model->getVehicleStaticCosts()
            ->with(['staticCosts'])
            ->joinWith('staticCosts')
            // we dont need "main vehicle added costs"
            ->andWhere(['NOT REGEXP', 'static_costs.short_name','^mnvhcl'])
            ->with('frequencyData')
            ->all();

        $staticCostsCalculationMaker    = new MakesStaticCostsCalculation($staticCosts, $monthDays, $workDays);

        $statistics = $staticCostsCalculationMaker->makeCalculation();

        return [
            'model' => $model,
            'statistics' => $statistics
        ];

    }
}

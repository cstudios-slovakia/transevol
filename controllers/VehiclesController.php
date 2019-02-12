<?php

namespace app\controllers;

use app\models\Companies;
use app\models\VehicleStaticCost;
use app\models\VehicleStaticCosts;
use app\models\VehicleStaticCostsForm;
use app\support\FrequencyDataBuilder;
use app\support\helpers\LoggedInUserTrait;
use app\support\StaticCostsCalculators\DaylyGoingsCalculator;
use app\support\StaticCostsCalculators\DaylyStaticCosts;
use app\support\StaticCostsCalculators\DaylyStaticCostsCalculator;
use app\support\StaticCostsCalculators\HourlyCostCalculator;
use app\support\StaticCostsCalculators\MonthlyStaticCosts;
use app\support\StaticCostsCalculators\MonthlyStaticCostsCalculator;
use app\support\Vehicles\Relations\RelationAssistance;
use app\support\Vehicles\Relations\VehicleRelationAssistance;
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
        $vehicles = Vehicles::find()->with('vehicleStaticCosts')->with('vehicleStaticCosts.frequencyData')->all();
        $data   = [];

        foreach ($vehicles as $vehicle) {
            $statistics = $this->oneVehicleStatistics($vehicle->id, $vehicle);

            $record     = array_merge(['ecv' => $vehicle->ecv,'id'=> $vehicle->id],$statistics['statistics']);

            $data[] = $record;
        }

        $dataProvider   = new ArrayDataProvider([
            'allModels' => $data
        ]);

        return $this->render('statistics/index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionStatistics(int $id)
    {
        $options = [];

        if ($this->request()->isPost) {
            $workDaysInput = $this->request()->post('work_days');
            $workDaysNumber = count(explode('|',$workDaysInput));
            $options['work_days'] = $workDaysNumber;
        }


        return $this->render('statistics/show',$this->oneVehicleStatistics($id,null,$options));

    }


    public function oneVehicleStatistics(int $id, Model $model = null,array $options = [])
    {
        if (!$model){
            $model = $this->findModel($id);
        }
        $staticCosts = $model->getVehicleStaticCosts()
            ->with(['staticCosts'])
            ->joinWith('staticCosts')
            ->andWhere(['NOT REGEXP', 'static_costs.short_name','^mnvhcl'])
            ->with('frequencyData')
            ->all();

        $monthlyStaticCosts = [];
        $daylyStaticCosts   = [];
        $daylyGoingsCosts   = [];

        $workDays = $this->request()->post('work_days', 20);
        $workHour = $this->request()->post('work_hours', 13);

        if (!empty($options) && array_key_exists('work_days',$options)){
            $workDays   = $options['work_days'];
        }


        foreach ($staticCosts as $staticCost) {
            $monthlyStaticCostCalculator     = new MonthlyStaticCostsCalculator();
            $monthlyStaticCostCalculator->setStaticCost($staticCost);
            $monthlyStaticCosts[]   = $monthlyStaticCostCalculator->costResult(true);

            $daylyStaticCostCalculator  = new DaylyStaticCostsCalculator();
            $daylyStaticCostCalculator->setStaticCost($staticCost);
            $daylyStaticCosts[] = $daylyStaticCostCalculator->costResult(true);

            if ($workDays) {
                $daylyGoingsCalculator  = new DaylyGoingsCalculator();
                $daylyGoingsCalculator->setWorkDays($workDays);
                $daylyGoingsCalculator->setMonthlyStaticCostsCalculator($monthlyStaticCostCalculator);
                $daylyGoingsCosts[] = $daylyGoingsCalculator->costResult(true);
            }
        }

        $daysInMonth = MonthlyStaticCostsCalculator::getMonthDays();

        $monthlyStaticCostsSum = array_sum($monthlyStaticCosts);

        $daylyStaticCostSum = array_sum($daylyStaticCosts);

        $daylyGoingsCostSum = array_sum($daylyGoingsCosts);

        $hourlyStaticCostCalculator = new HourlyCostCalculator(24, $daysInMonth, $monthlyStaticCostsSum);

        $hourlyStaticCostSum    = $hourlyStaticCostCalculator->costResult(true);

        $hourlyGoingsSum = 0;

        if ($workDays){
            $hourlyGoingsCalculator     = new HourlyCostCalculator($workHour, $workDays, $monthlyStaticCostsSum);
            $hourlyGoingsSum = $hourlyGoingsCalculator->costResult(true);
        }

        return [
            'model' => $model,
            'statistics' => [
                'monthly'   => $monthlyStaticCostsSum,
                'monthDays' => $daysInMonth,
                'dayly'     => $daylyStaticCostSum,
                'workDays'  => $workDays,
                'daylyWorks'    => $daylyGoingsCostSum,
                'hourly'    => $hourlyStaticCostSum,
                'hourlyGoings'  => $hourlyGoingsSum,
                'workHour'  => $workHour,
            ]

        ];

//        return $this->render('statistics/show',[
//            'model' => $model,
//            'statistics' => [
//                'monthly'   => $monthlyStaticCostsSum,
//                'monthDays' => $daysInMonth,
//                'dayly'     => $daylyStaticCostSum,
//                'workDays'  => $workDays,
//                'daylyWorks'    => $daylyGoingsCostSum,
//                'hourly'    => $hourlyStaticCostSum,
//                'hourlyGoings'  => $hourlyGoingsSum,
//                'workHour'  => $workHour,
//            ]
//
//        ]);

    }
}

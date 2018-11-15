<?php

namespace app\controllers;

use app\models\Companies;
use app\models\VehicleStaticCost;
use app\models\VehicleStaticCosts;
use app\models\VehicleStaticCostsForm;
use app\support\FrequencyDataBuilder;
use app\support\Vehicles\Relations\RelationAssistance;
use app\support\Vehicles\Relations\VehicleRelationAssistance;
use Yii;
use app\models\Vehicles;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VehiclesController implements the CRUD actions for Vehicles model.
 */
class VehiclesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

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
//        $timeSelect = FrequencyDataBuilder::makeType('time')->dropDownListOptions();
//        $lengthSelect = FrequencyDataBuilder::makeType('length')->dropDownListOptions();
//
//        dd($timeSelect,$lengthSelect);

        $model = new Vehicles();
        $vehicleStaticCostFormModel  = new VehicleStaticCostsForm();

        $request = Yii::$app->request;

        $staticCosts = VehicleStaticCost::find()->all();
        $staticCostsCollection = collect($staticCosts)->keyBy('short_name');

        if ($model->load($request->post()) && $vehicleStaticCostFormModel->load($request->post()) &&
            Model::validateMultiple([$model,$vehicleStaticCostFormModel]) ) {
            // TODO company should be linked from logged in user
            $company    = Companies::find()->orderBy(new Expression('rand()'))->one();

            $model->link('companies', $company);
            $model->save();

            $staticCostInputs = $request->post()['VehicleStaticCostsForm'];

            foreach ($staticCostInputs as $shortName => $value){
                $vehicleStaticCost = new VehicleStaticCosts();
                $vehicleStaticCost->value   = $value;
                $vehicleStaticCost->vehicles_id     = $model->id;
                $vehicleStaticCost->link('staticCosts', $staticCostsCollection->get($shortName));
                $vehicleStaticCost->save();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model'             => $model,
            'vehicleStaticCostFormModel' => $vehicleStaticCostFormModel,
            'staticCostsCollection'    => $staticCostsCollection
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
//        dd($vehicleStaticCostFormModel->load($request->post()));
        if ($model->load($request->post()) && $vehicleStaticCostFormModel->load($request->post()) &&
            Model::validateMultiple([$model,$vehicleStaticCostFormModel]) ) {
            // TODO company should be linked from logged in user
            $company    = Companies::find()->orderBy(new Expression('rand()'))->one();

            $model->link('companies', $company);
            $model->update();

            $staticCostInputs = $request->post()['VehicleStaticCostsForm'];



            foreach ($associatedStaticCosts as $shortName => $vehicleStaticCost){

                $vehicleStaticCost->value   = $staticCostInputs[$shortName];
//                $vehicleStaticCost->vehicles_id     = $model->id;
//                $vehicleStaticCost->link('staticCosts', $staticCostsCollection->get($shortName));
                $vehicleStaticCost->update();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        $loadable = $associatedStaticCosts->transform(function($vehicleStaticCosts){
            return $vehicleStaticCosts->value;
        })->toArray();

         $vehicleStaticCostFormModel->load($loadable,'');


        return $this->render('update', [
            'model'             => $model,
            'vehicleStaticCostFormModel' => $vehicleStaticCostFormModel,
            'staticCostsCollection'    => $staticCostsCollection
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
}

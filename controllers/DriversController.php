<?php

namespace app\controllers;

use app\models\Companies;
use app\models\DriverCostDatas;
use app\models\DriverForm;
use app\models\DriverStaticCost;
use app\models\StaticCost;
use Yii;
use app\Models\Drivers;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DriversController implements the CRUD actions for Drivers model.
 */
class DriversController extends Controller
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
     * Lists all Drivers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Drivers::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Drivers model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model  = $this->findModel($id);

        $staticCostDataProvider     = new ActiveDataProvider([
            'query'     => $model->getDriverCostDatas(),
        ]);

        return $this->render('view', [
            'model' => $model,
            'staticCostDataProvider'    => $staticCostDataProvider

        ]);
    }

    /**
     * Creates a new Drivers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Drivers();
        $driverForm = new DriverForm();

        if ($model->load(Yii::$app->request->post(),'Drivers') && $driverForm->load(Yii::$app->request->post(),'StaticCosts') &&
        Model::validateMultiple([$model, $driverForm])
        ) {

            $model->link('companies',Companies::findOne(['id' => 1]));
            $model->save();
            foreach (Yii::$app->request->post('StaticCosts') as $shortName => $staticCostValue){
                $staticCost     = StaticCost::findOne(['short_name' => $shortName]);

                $model->link('staticCosts',$staticCost,['value' => $staticCostValue]);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }
        $driverStaticCosts = DriverStaticCost::find()->all();


        return $this->render('create', [
            'model' => $model,
            'costs'     => collect($driverStaticCosts)
        ]);
    }

    /**
     * Updates an existing Drivers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $driverForm = new DriverForm();

        // make a costdata collection defined by costdata's type shortname
        $driverCostData = collect($model->driverCostDatas)->keyBy(function($costData){
            return $costData->staticCosts->short_name;
        });

        if ($model->load(Yii::$app->request->post(),'Drivers') && $driverForm->load(Yii::$app->request->post(),'StaticCosts') &&
            Model::validateMultiple([$model, $driverForm])
        ) {

            $model->link('companies',Companies::findOne(['id' => 1]));
            $model->update();

            foreach (Yii::$app->request->post('StaticCosts') as $shortName => $staticCostValue){
                $staticCost     = $driverCostData->get($shortName,null);

                // if cost data does not exists link one
                if(!$staticCost){
                    $staticCost     = StaticCost::findOne(['short_name' => $shortName]);
                    $model->link('staticCosts',$staticCost,['value' => $staticCostValue]);
                    continue;
                }
                $staticCost->value = $staticCostValue;
                $staticCost->update(false);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'costs'     => collect($driverCostData)
        ]);
    }

    /**
     * Deletes an existing Drivers model.
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
     * Finds the Drivers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Drivers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Drivers::find()->with(['staticCosts'])->where(['id' => $id])->one()) !== null) {

            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

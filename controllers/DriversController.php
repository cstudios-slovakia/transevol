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
        return $this->render('view', [
            'model' => $this->findModel($id),
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
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
        if (($model = Drivers::findOne($id)) !== null) {

            var_dump($model->staticCosts);
            die();
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

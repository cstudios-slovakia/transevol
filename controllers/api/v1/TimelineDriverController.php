<?php

namespace app\controllers\api\v1;

use app\models\Vehicles;
use app\support\Drivers\Relations\DriverRelationAssistance;
use Yii;
use app\models\TimelineDriver;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TimelineDriverController implements the CRUD actions for TimelineDriver model.
 */
class TimelineDriverController extends Controller
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
     * Lists all TimelineDriver models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => TimelineDriver::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TimelineDriver model.
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
     * Creates a new TimelineDriver model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TimelineDriver();

        $model->setScenario('start');

        if ($model->load(Yii::$app->request->post())) {

            $model->save();

            $vehicleId = Yii::$app->session->get('vehicleId');

            $vehicle = Vehicles::findOne(['id' => $vehicleId]);

            $model->link('vehicles', $vehicle);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        $driverSelectOptions = DriverRelationAssistance::ownedDriversSelectOptions();

        return $this->render('create', [
            'model' => $model,
            'driverSelectOptions'  => $driverSelectOptions
        ]);
    }

    /**
     * Updates an existing TimelineDriver model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->setScenario($model::SCENARIO_FINNISH);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $driverSelectOptions = DriverRelationAssistance::ownedDriversSelectOptions();

        return $this->render('update', [
            'model' => $model,
            'driverSelectOptions'  => $driverSelectOptions

        ]);
    }

    /**
     * Deletes an existing TimelineDriver model.
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
     * Finds the TimelineDriver model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TimelineDriver the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TimelineDriver::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

//    public function showDriverTimelineFinish()
//    {
//        $driverSelectOptions = DriverRelationAssistance::ownedDriversSelectOptions();
//
//        return $this->render('',[
//            'driverSelectOptions'   => $driverSelectOptions,
//        ]);
//    }
}

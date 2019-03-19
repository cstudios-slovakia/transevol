<?php

namespace app\controllers\api\v1;

use app\support\Vehicles\Relations\VehicleRelationAssistance;
use app\support\Vehicles\UseCurrentVehicle;

use Yii;
use app\models\TimelineVehicle;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TimelineVehicleController implements the CRUD actions for TimelineVehicle model.
 */
class TimelineVehicleController extends Controller
{
    use UseCurrentVehicle;
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
     * Lists all TimelineVehicle models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => TimelineVehicle::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TimelineVehicle model.
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
     * Creates a new TimelineVehicle model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TimelineVehicle();

        $ownedVehicles  = VehicleRelationAssistance::ownedVehicles();

        if ($model->load(Yii::$app->request->post())) {

            $model->save();

            $model->link('timelineVehicle',$this->getVehicle());

            return $this->redirect(Url::toRoute('/transporter/viewer'));

        }

        return $this->render('create', [
            'model' => $model,
            'ownedVehicles'     => $ownedVehicles,
        ]);
    }

    /**
     * Updates an existing TimelineVehicle model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $ownedVehicles  = VehicleRelationAssistance::ownedVehicles();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $timelineVehicle = $model->timelineVehicle;

            $model->link('timelineVehicle',$this->getVehicle());


            return $this->redirect(Url::toRoute('/transporter/viewer'));

        }

        return $this->render('update', [
            'model' => $model,
            'ownedVehicles'     => $ownedVehicles,

        ]);
    }

    /**
     * Deletes an existing TimelineVehicle model.
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
     * Finds the TimelineVehicle model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TimelineVehicle the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TimelineVehicle::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}

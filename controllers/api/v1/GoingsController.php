<?php

namespace app\controllers\api\v1;

use app\controllers\BaseController;
use app\models\Vehicles;
use app\support\helpers\LoggedInUserTrait;
use Carbon\Carbon;
use Yii;
use app\models\Goings;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GoingsController implements the CRUD actions for Goings model.
 */
class GoingsController extends BaseController
{
    use LoggedInUserTrait;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $baseBehaviors  = parent::behaviors();

        $baseBehaviors['access']['only']    = ['update'];

        return $baseBehaviors;
    }

//    /**
//     * Lists all Goings models.
//     * @return mixed
//     */
//    public function actionIndex()
//    {
//        $dataProvider = new ActiveDataProvider([
//            'query' => Goings::find(),
//        ]);
//
//        return $this->render('index', [
//            'dataProvider' => $dataProvider,
//        ]);
//    }

    /**
     * Displays a single Goings model.
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
     * Creates a new Goings model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Goings();


        $company = LoggedInUserTrait::loggedInUserCompany();

        if ($model->load(Yii::$app->request->post())) {

            $vehicleId = Yii::$app->session->get('vehicleId');
            $vehicle = Vehicles::findOne(['id' => $vehicleId]);


            if (empty($this->request()->post('Goings')['going_until'])){
                $untilFormat = 'Y-m-d H:i';

                $from   = $this->request()->post('Goings')['going_from'];

                $until = Carbon::createFromFormat( $untilFormat, $from);

                $model->going_until = $until->addHours(13)->format($untilFormat);
            }

            $model->save();

            $model->link('vehicles',$vehicle);

            return $this->redirect(Url::toRoute('/transporter/viewer'));

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Goings model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

//        $model->setScenario($model::SCENARIO_FINNISH);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(Url::toRoute('/transporter/viewer'));

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Goings model.
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
     * Finds the Goings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Goings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Goings::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionEnding()
    {
        $company = static::loggedInUserCompany();

        $goingsSelectOptions = collect(Goings::findAll(['companies_id' => $company->id]))
            ->pluck('going_from','id')
            ->toArray();

        return $this->render('ending',[
            'goingsSelectOptions' => $goingsSelectOptions
        ]);
    }

    public function actionCloseOne()
    {

        $closeableId = $this->request()->post('goings_id');
        $model = $this->findModel((int) $closeableId);

        $model->setScenario($model::SCENARIO_FINNISH);

        $model->going_until = $this->request()->post('going_until');

        $model->validate();

        $model->save();

        return $this->redirect(Url::toRoute('/transporter/viewer'));
        dd($closeableId,$model,$this->request()->post());
    }
}

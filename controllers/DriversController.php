<?php

namespace app\controllers;

use app\models\Companies;
use app\models\DriverCostDatas;
use app\models\DriverForm;
use app\models\DriverStaticCost;
use app\models\DriverStaticCostsForm;
use app\models\StaticCost;
use app\support\helpers\LoggedInUserTrait;
use Yii;
use app\models\Drivers;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DriversController implements the CRUD actions for Drivers model.
 */
class DriversController extends BaseController
{
    use LoggedInUserTrait;


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


        $driverStaticCostsForm = new DriverStaticCostsForm();

        $request = $this->request();

//        dd(
//            $model->load($request->post(),'Drivers'),
//            $driverStaticCostsForm->load($request->post(),'StaticCostsForm'),
//
//            Model::validateMultiple([$model, $driverStaticCostsForm]),
//
//            $driverStaticCostsForm->getErrors()
//        );

        if ($model->load($request->post(),'Drivers') && $driverStaticCostsForm->load($request->post(),'StaticCostsForm') &&
        Model::validateMultiple([$model, $driverStaticCostsForm])
        ) {

            $company = self::loggedInUserCompany();

            $model->link('companies', $company);
            $model->save();
            foreach ($request->post('StaticCostsForm') as $shortName => $staticCostValue){
                $staticCost     = StaticCost::findOne(['short_name' => $shortName]);

                $model->link('staticCosts',$staticCost,[
                    'value' => $staticCostValue['value'],
                    'frequency_datas_id' => $staticCostValue['frequency_datas_id'],
                ]);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }
        $driverStaticCosts = DriverStaticCost::find()->all();


        return $this->render('create', [
            'model' => $model,
            'driverStaticCostsForm' => $driverStaticCostsForm,
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

        $driverStaticCostsForm = new DriverStaticCostsForm();

        // make a costdata collection defined by costdata's type shortname
        $driverCostData = collect($model->driverCostDatas)->keyBy(function($costData){
            return $costData->staticCosts->short_name;
        });

        $request = $this->request();


        if ($model->load($request->post(),'Drivers') && $driverStaticCostsForm->load($request->post(),'StaticCostsForm')) {
            $validDriver = $model->validate();
            $validDriverStaticCostsForm = $driverStaticCostsForm->validate();

            if($validDriver && $validDriverStaticCostsForm){

                $model->update();
                foreach ($request->post('StaticCostsForm') as $shortName => $staticCostsData){
                    $staticCost     = $driverCostData->get($shortName,null);

                    // if cost data does not exists link one
                    if(!$staticCost){
                        $staticCost     = StaticCost::findOne(['short_name' => $shortName]);
                        $model->link('staticCosts',$staticCost,['value' => $staticCostsData['value']]);
                        continue;
                    }
                    $staticCost->value = $staticCostsData['value'];
                    $staticCost->update(false);
                }

                return $this->redirect(['view', 'id' => $model->id]);

            }
        }

        $driverStaticCosts = DriverStaticCost::find()->all();
        return $this->render('update', [
            'model' => $model,
            'driverStaticCostsForm' => $driverStaticCostsForm,
            'costs'     => collect($driverStaticCosts)
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

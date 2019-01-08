<?php

namespace app\controllers;

use app\models\Addresses;
use app\models\Companies;
use app\models\ListingsModel;
use app\models\PlaceTypes;
use app\models\ServiceListingsQuery;
use app\support\helpers\AppParams;
use app\support\helpers\LoggedInUserTrait;
use Yii;
use app\models\Listings;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ListingsController implements the CRUD actions for Listings model.
 */
class ListingsController extends BaseController
{
    use LoggedInUserTrait;

    /**
     * Lists all Listings models.
     * @return mixed
     */
    public function actionIndex(string $type = '')
    {

        $listingsConfig = AppParams::getListings();


        if(empty($type) || !in_array($type,$listingsConfig,true)){
            throw new \Exception('This listings type does not exists!');
        }

        $listings = Listings::find()->joinWith('placeTypes')
            ->where(['placetype_name' => $type]);


        $dataProvider = new ActiveDataProvider([
            'query' => $listings,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Listings model.
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
     * Creates a new Listings model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new ListingsModel();

        $input = $this->request()->post();

        if ($model->load($input) && $model->validate() && $model->store()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Listings model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $addressesModel = $model->addresses;

        $input = $this->request()->post();

        if ($model->load($input) && $addressesModel->load($input) && Model::validateMultiple([$model, $addressesModel])) {

            $addressesModel->update();

            $model->countries_id  = $addressesModel->countries_id;
            $model->update();

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Listings model.
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
     * Finds the Listings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Listings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Listings::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

<?php

namespace app\controllers;

use app\models\Addresses;
use app\models\Countries;
use Yii;
use app\models\Places;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PlacesController implements the CRUD actions for Places model.
 */
class PlacesController extends Controller
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
     * Lists all Places models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Places::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Places model.
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
     * Creates a new Places model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $placesModel    = new Places();
        $addressesModel     = new Addresses();

        $postData   = Yii::$app->request->post();


        if ($placesModel->load($postData) && $addressesModel->load($postData) &&
            Model::validateMultiple([$placesModel,$addressesModel])) {

            $countries  = Countries::find(['id' => 'countries_id'])->one();


            $addressesModel->link('countries',$countries);
            $addressesModel->save();

//            $countries   = $addressesModel->getCountries()->one();
//            var_dump($countries);
//            exit();

            $placesModel->countries_id  = $countries->id;

            $placesModel->link('addresses',$addressesModel);
            $placesModel->link('countries',$countries);

            $placesModel->save();



            return $this->redirect(['view', 'id' => $placesModel->id]);
        }

        $countries  = Countries::find()->all();

        return $this->render('create', [
            'placesModel'       => $placesModel,
            'addressesModel'    => $addressesModel,
            'related'   => [
                'countries' => ArrayHelper::map($countries,'id','country_name')
            ]
        ]);
    }

    /**
     * Updates an existing Places model.
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
     * Deletes an existing Places model.
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
     * Finds the Places model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Places the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Places::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

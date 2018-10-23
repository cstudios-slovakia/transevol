<?php

namespace app\controllers;

use app\models\Addresses;
use app\models\Companies;
use app\models\Countries;
use app\models\PlaceTypes;
use app\Support\Helpers\AppParams;
use Yii;
use app\models\Places;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
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
     * @param string $type
     * @return string
     */
    public function actionIndex(string $type = '')
    {
        // we have defined places in params, lets reuse them
        $placeCollections   = AppParams::coreParam('place_collections');

        $query  = Places::find();

        // check type is defined, if not simple use default
        if(in_array($type, $placeCollections)){

            // building query, make attention that this query replaces query above,
            // and search for places for needed type
            $query  = $query->leftJoin('place_types','`places`.`place_types_id` = `place_types`.`id`')
                ->where(['place_types.place_section' => $type]);

        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
        $placesModel        = new Places();
        $addressesModel     = new Addresses();

        $request   = \Yii::$app->request;

        if ($placesModel->load($request->post()) && $addressesModel->load($request->post()) &&
            Model::validateMultiple([$placesModel,$addressesModel])) {

            $countries_id   = (int) $request->post('Addresses')['countries_id'];

            $countries  = Countries::find()->where(['id' => $countries_id])->one();

            $addressesModel->link('countries',$countries);
            $addressesModel->save();

            $placesModel->countries_id  = $countries->id;
            // TODO implement real company owner, which is defined by a logged one user
            // now simple random finding is enough
            $company        = Companies::find()
                ->orderBy(new Expression('rand()'))
                ->limit(1)
                ->one();
            $placesModel->companies_id  = $company->id;

            $placesModel->link('addresses',$addressesModel);

            $placesModel->save();

            return $this->redirect(['view', 'id' => $placesModel->id]);
        }

        // add relations and populate dropdowns
        $countries      = Countries::find()->all();
        $placeTypes     = PlaceTypes::find()->all();

        return $this->render('create', [
            'placesModel'       => $placesModel,
            'addressesModel'    => $addressesModel,
            'related'   => [
                'countries' => ArrayHelper::map($countries,'id','country_name'),
                'placetypes' => ArrayHelper::map($placeTypes,'id','placetype_name'),
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

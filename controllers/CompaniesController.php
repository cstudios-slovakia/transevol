<?php

namespace app\controllers;

use app\models\CompanyCostDatas;
use app\models\CompanyDynamicCosts;
use app\models\CompanyDynamicCostsForm;
use app\models\CompanyDynamicOtherCosts;
use app\models\CompanyDynamicPersonalCosts;
use app\models\CompanyStaticCostQuery;
use app\models\CompanyStaticCostsForm;
use app\models\FrequencyData;
use app\models\Units;
use Carbon\Carbon;
use Yii;
use app\models\Companies;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * CompaniesController implements the CRUD actions for Companies model.
 */
class CompaniesController extends BaseController
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
     * Lists all Companies models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Companies::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Companies model.
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
     * Creates a new Companies model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $company = new Companies();
        $companyStaticCostsForm     = new CompanyStaticCostsForm();

        $companyStaticCosts = collect(CompanyStaticCostQuery::find()->all())->keyBy('short_name');

        if ($company->load($this->request()->post()) && $companyStaticCostsForm->load($this->request()->post()) &&
        Model::validateMultiple([$company, $companyStaticCostsForm])) {

            $company->save();

            $companyStaticCosts->each(function($companyStaticCost,$shortName) use ($companyStaticCostsForm, $company){
                $companyStaticCostData  = new CompanyCostDatas();
                $companyStaticCostData->value   = $companyStaticCostsForm->{$shortName};
                $companyStaticCostData->static_costs_id     = $companyStaticCost->id;
                $companyStaticCostData->link('companies',$company);
                $companyStaticCostData->save();
            });

            return $this->redirect(['view', 'id' => $company->id]);
        }

        return $this->render('create', [
            'model'                 => $company,
            'companyStaticCosts'    => $companyStaticCosts->toArray(),
            'companyStaticCostsForm'    => $companyStaticCostsForm,
        ]);
    }

    /**
     * Updates an existing Companies model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $company = $this->findModel($id);
        $companyStaticCostsForm     = new CompanyStaticCostsForm();

        $companyStaticCosts     = collect($company->companyCostDatas)->keyBy(function ($companyCostData){
            return $companyCostData->staticCosts->short_name;
        });

        if ($company->load($this->request()->post()) && $companyStaticCostsForm->load($this->request()->post()) &&
        Model::validateMultiple([$company, $companyStaticCostsForm])) {

            $staticCostsInput = $this->request()->post()['CompanyStaticCostsForm'];

            foreach ($companyStaticCosts as $staticCostShortName => $companyStaticCost) {
                $companyStaticCost->value   = $staticCostsInput[$staticCostShortName];
                $companyStaticCost->update();
            }

            return $this->redirect(['view', 'id' => $company->id]);
        }


        $loadable = $companyStaticCosts->transform(function($companyStaticCost){
            return $companyStaticCost->value;
        })->toArray();

        $companyStaticCostsForm->load($loadable,'');

        return $this->render('update', [
            'model' => $company,
            'companyStaticCosts'        => $companyStaticCosts->toArray(),
            'companyStaticCostsForm'    => $companyStaticCostsForm,
            'companyPersonalDynamicCosts'   => $company->companyPersonalDynamicCosts,
            'companyOtherDynamicCosts'      => $company->companyOtherDynamicCosts,

        ]);
    }

    /**
     * Deletes an existing Companies model.
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
     * Finds the Companies model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Companies the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Companies::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAjax()
    {

        if(! $this->request()->isAjax){
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'status_code'   => 401,
                'message'   => 'Invalid request!'
            ];
        }

        $companyDynamicCostForm     = new CompanyDynamicCostsForm();
        $companyDynamicCostForm->setScenario($action = $this->request()->post('action'));
        $companyDynamicCostForm->companies_id = (int) $this->request()->get('company_id');
        $companyDynamicCostForm->load($ajaxData = $this->request()->post(),'');


        $valid = $companyDynamicCostForm->validate();


        if ($valid) {

            $companyDynamicCostForm->{$action.'DynamicCost'}();

            $queryType  = $companyDynamicCostForm->cost_type === CompanyDynamicCosts::DYNAMIC_PERSONAL ? new CompanyDynamicPersonalCosts() : new CompanyDynamicOtherCosts();

            $dynamicCosts = $queryType::findAll(['companies_id' => $companyDynamicCostForm->companies_id]);


        }

        return $this->renderPartial('_partials/dynamic_cost_table',[
            'dynamicCosts'   => $dynamicCosts
        ]);

    }

}

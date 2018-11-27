<?php

namespace app\controllers;

use app\models\CompanyCostDatas;
use app\models\CompanyDynamicCosts;
use app\models\CompanyDynamicCostsForm;
use app\models\CompanyDynamicOtherCosts;
use app\models\CompanyDynamicPersonalCosts;
use app\models\CompanyOwned;
use app\models\CompanyStaticCostQuery;
use app\models\CompanyStaticCostsForm;
use app\models\FrequencyData;
use app\models\Units;
use app\support\helpers\LoggedInUserTrait;
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
    use LoggedInUserTrait;
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

//    /**
//     * Lists all Companies models.
//     * @return mixed
//     */
//    public function actionIndex()
//    {
//        $dataProvider = new ActiveDataProvider([
//            'query' => CompanyOwned::find(),
//        ]);
//
//        return $this->render('index', [
//            'dataProvider' => $dataProvider,
//        ]);
//    }

    /**
     * Displays a single Companies model.
//     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {
        $company = $this->findModel();

//        dd($company->getRelation('companyCostDatas')->all());

        $costDatasDataProvider = new ActiveDataProvider([
            'query' => $company->getRelation('companyCostDatas'),
//            'pagination' => [
//                'pageSize' => 20,
//            ],
        ]);

        $dynamicCostDataProvider = new ActiveDataProvider([
            'query' => $company->getRelation('companyDynamicCosts'),
//            'pagination' => [
//                'pageSize' => 20,
//            ],
        ]);
        return $this->render('view', [
            'model' => $company,
            'costDatasDataProvider' => $costDatasDataProvider,
            'dynamicCostDataProvider' => $dynamicCostDataProvider,
        ]);
    }

    /**
     * Creates a new Companies model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $company = $this->findModel();

        if($company && $company->id){
            return $this->redirect(['view']);
        }

        $company = new Companies();
        $companyStaticCostsForm     = new CompanyStaticCostsForm();

        $companyStaticCosts = collect(CompanyStaticCostQuery::find()->all())->keyBy('short_name');

        if ($company->load($this->request()->post()) && $companyStaticCostsForm->load($this->request()->post(),'StaticCostsForm') &&
        Model::validateMultiple([$company, $companyStaticCostsForm])) {
            $company->save();

            $user = Yii::$app->user->identity;
            $user->companies_id = $company->id;
            $user->save();

            $companyStaticCosts->each(function($companyStaticCost,$shortName) use ($companyStaticCostsForm, $company){
                $staticCostInput = $companyStaticCostsForm->{$shortName};

                $companyStaticCostData  = new CompanyCostDatas();
                $companyStaticCostData->value   = $staticCostInput['value'];
                $companyStaticCostData->static_costs_id     = $companyStaticCost->id;
                $companyStaticCostData->frequency_datas_id     = $staticCostInput['frequency_datas_id'];
                $companyStaticCostData->link('companies',$company);
                $companyStaticCostData->save();
            });



            return $this->redirect(['view']);

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
    public function actionUpdate()
    {
        $company = $this->findModel();
        $companyStaticCostsForm     = new CompanyStaticCostsForm();



        $companyStaticCosts = collect(CompanyStaticCostQuery::find()->all())->keyBy('short_name');

        if ($company->load($this->request()->post()) && $companyStaticCostsForm->load($this->request()->post()) &&
        Model::validateMultiple([$company, $companyStaticCostsForm])) {

            $staticCostsInput = $this->request()->post()['CompanyStaticCostsForm'];

            foreach ($companyStaticCosts as $staticCostShortName => $companyStaticCost) {
                $companyStaticCost->value   = $staticCostsInput[$staticCostShortName];
                $companyStaticCost->update();
            }

            return $this->redirect(['view', 'id' => $company->id]);
        }



        $loadable = $companyStaticCosts->toArray();
        $companyStaticCostsForm->load($loadable,'');
//        dd($companyStaticCostsForm);
        $dynPersonal = $company->companyPersonalDynamicCosts;
        $dynOther = $company->companyOtherDynamicCosts;


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
    protected function findModel()
    {
//        if (($model = Companies::findOne($id)) !== null) {
//            return $model;
//        }
//        $model = CompanyOwned::find()->one();
        $model = self::loggedInUserCompany();

        // TODO user can NOT access other company other than own.
        return $model;

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
//        dd($companyDynamicCostForm);

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

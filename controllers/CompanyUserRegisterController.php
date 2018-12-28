<?php

namespace app\controllers;

use app\models\CompanyOwned;
use app\models\RegistrationForm;
use app\models\userOverrides\CompanyUserRegistrationForm;
use app\support\helpers\LoggedInUserTrait;
use Yii;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

use dektrium\user\controllers\RegistrationController as BaseRegistrationController;

/**
 * CompanyUserRegisterController implements the CRUD actions for User model.
 */
class CompanyUserRegisterController extends BaseRegistrationController
{

    use LoggedInUserTrait;

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'actions' => ['index','register','view'], 'roles' => ['roleCompanyAdmin']],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {


        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->where(['companies_id' => self::loggedInUserCompany()->id]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * @inheritdoc
     */
    public function actionRegister()
    {

        if (!$this->module->enableRegistration) {
            throw new NotFoundHttpException();
        }

        /** @var CompanyUserRegistrationForm $model */
        $model = \Yii::createObject(CompanyUserRegistrationForm::className());
        $event = $this->getFormEvent($model);
//        dd($model->scenarios());
        $model->setScenario('companyUser');

        $this->trigger(self::EVENT_BEFORE_REGISTER, $event);

        $this->performAjaxValidation($model);
         $model->load(\Yii::$app->request->post());

//        dd($model,\Yii::$app->request->post());


        if ($model->load(\Yii::$app->request->post()) && $model->register()) {
            $this->trigger(self::EVENT_AFTER_REGISTER, $event);

            $registeredUser = $model->getRegisteredUser();



            \Yii::$app->session->setFlash(
                'info',
                \Yii::t(
                    'user',
                    'User was added into company!'
                )
            );

            return $this->redirect(['view', 'id' => $registeredUser->id]);

        }

        return $this->render('./../company-user-register/create', [
            'model' => $model,
        ]);



    }


    /**
     * Updates an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {

            if($model->companies_id !== self::loggedInUserCompany()->id){
                throw new \Exception('Company is not the same.');
            }

            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}

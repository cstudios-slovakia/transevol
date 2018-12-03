<?php

namespace app\controllers;

use app\models\CompanyOwned;
use app\models\RegistrationForm;
use app\models\userOverrides\CompanyUserRegistrationForm;
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

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'actions' => ['index'], 'roles' => ['@']],
                    ['allow' => true, 'actions' => ['register'], 'roles' => ['companyAdmin']],
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
            'query' => CompanyOwned::find()->user,
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
        dd($id);
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
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}

<?php

namespace app\controllers;

use app\models\User;
use dektrium\user\controllers\RegistrationController as BaseRegistrationController;
use dektrium\user\events\UserEvent;
use dektrium\user\models\RegistrationForm;
use yii\helpers\Url;

class RegistrationController extends BaseRegistrationController
{
    public $layout = '@app/views/layouts/public/base.php';
    /**
     * @inheritdoc
     */
    public function actionRegister()
    {
        if (!$this->module->enableRegistration) {
            throw new NotFoundHttpException();
        }
        /** @var RegistrationForm $model */
        $model = \Yii::createObject(RegistrationForm::className());
        $event = $this->getFormEvent($model);

        $this->trigger(self::EVENT_BEFORE_REGISTER, $event);

        $this->performAjaxValidation($model);
        $model->load(\Yii::$app->request->post());

        if ($model->load(\Yii::$app->request->post()) && $model->register()) {
            $this->trigger(self::EVENT_AFTER_REGISTER, $event);

            $registeredUser = $model->getRegisteredUser();

            if (!$registeredUser){
                return $this->redirectToLogin();
            }

            \Yii::$app->user->login($registeredUser);

            \Yii::$app->session->setFlash(
                'info',
                \Yii::t(
                    'user',
                    'Fill in company info!'
                )
            );

            return $this->redirectToCompanyCreate();

        }


        return $this->render('register', [
            'model'  => $model,
            'module' => $this->module,
        ]);
    }

    private function redirectToLogin()
    {
        return $this->redirect(Url::toRoute(['user/login'], true));
    }

    private function redirectToCompanyCreate()
    {
        return $this->redirect(Url::toRoute(['/companies/create'],true));
    }
}
<?php

namespace app\controllers;

use app\models\User;
use app\models\RegistrationForm;

class RegisterController extends BaseController
{
    public function actionRegister()
    {

        $registrationForm = new RegistrationForm();

        $input = $this->request()->post();

        if($registrationForm->load($input,'RegistrationForm') && $registrationForm->validate()){
//            dd($registrationForm, $input);

            $registered = $registrationForm->registerUser($input['RegistrationForm']);

            dd($registered);
        }




        return $this->render('register',['model' => $registrationForm]);
    }

}

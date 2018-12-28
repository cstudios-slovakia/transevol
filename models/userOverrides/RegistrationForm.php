<?php

namespace app\models\userOverrides;

use app\models\User;
use dektrium\user\models\RegistrationForm as BaseRegistrationForm;
use yii\base\NotSupportedException;
use yii\rbac\Assignment;

class RegistrationForm extends BaseRegistrationForm
{



    const SCENARIO_REGISTRATION_LEVEL = 'rolCompanyAdmin';


    /**
     * @var null|User
     */
    protected $registeredUser = null;

    /**
     * @inheritdoc
     */
    public function register()
    {
        if (!$this->validate()) {
            return false;
        }

        /** @var User $user */
        $user = \Yii::createObject(User::className());
        $user->setScenario('register');
        $this->loadAttributes($user);
        if ($this->getScenario() === CompanyUserRegistrationForm::SCENARIO_REGISTRATION_LEVEL){
            $this->associateCompany($user);
        }

        if (!$user->register()) {
            return false;
        }

        $this->registeredUser = $user;

        $this->addRoleToUser(static::SCENARIO_REGISTRATION_LEVEL, $user);

        \Yii::$app->session->setFlash(
            'info',
            \Yii::t(
                'user',
                'Your account has been created and a message with further instructions has been sent to your email'
            )
        );

        return true;
    }

    protected function addRoleToUser(string $roleName, User $user) : Assignment
    {
        $auth = \Yii::$app->authManager;

        $roles = $auth->getRoles();

        if (!array_key_exists($roleName, $roles)) {
            throw new NotSupportedException('Wanted role does not exists.');
        }

        $role = $roles[$roleName];

        return $auth->assign($role, $user->id);


    }


    /**
     * @return User|null
     */
    public function getRegisteredUser()
    {
        return $this->registeredUser;
    }

    protected function associateCompany($user){}

}

?>
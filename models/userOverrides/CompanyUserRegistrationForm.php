<?php

namespace app\models\userOverrides;

use app\support\helpers\LoggedInUserTrait;

class CompanyUserRegistrationForm extends RegistrationForm
{
    use LoggedInUserTrait;

    const SCENARIO_REGISTRATION_LEVEL = 'companyUser';

    /*
     * At this time we have to define which company belongs.
     */
    public $companies_id;

    public function thisIsMyConst()
    {
        return self::SCENARIO_REGISTRATION_LEVEL;
    }

    public function formName()
    {
        return 'company-user-registration-form';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_REGISTRATION_LEVEL] = ['companies_id','email','username','password'];
        return $scenarios;
    }

   public function register()
   {
       return parent::register(); // TODO: Change the autogenerated stub
   }

   public function rules()
   {
       return parent::rules(); // TODO: Change the autogenerated stub
   }

    public function associateCompany($user)
    {
        $user->setAttribute('companies_id', self::loggedInUserCompany()->id);
        parent::associateCompany($user); // TODO: Change the autogenerated stub
    }
}


?>
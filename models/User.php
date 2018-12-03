<?php

namespace app\models;

use app\support\helpers\LoggedInUserTrait;
use yii\behaviors\TimestampBehavior;

use dektrium\user\models\User as BaseUser;

class User extends BaseUser
{




    public static function tableName()
    {
        return 'user';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }



    public function rules()
    {
        $rules = parent::rules();
        $rules['companies_idInteger'] = [ 'companies_id', 'integer'];

        return $rules;
    }

    public function getCompany()
    {
        return $this->hasOne(Companies::className(),['id' => 'companies_id']);
    }

//    public function beforeValidate()
//    {
//        if ($this->getScenario() === self::SCENARIO_REGISTRATION_LEVEL_USER){
//
//            $associatedCompany = self::loggedInUserCompany();
//
//            $this->setAttribute('companies_id', $associatedCompany->id);
//        }
//
//        return parent::beforeValidate();
//    }

}

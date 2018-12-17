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

    public function getIsAdmin()
    {
        return
            (\Yii::$app->getAuthManager() && $this->module->adminPermission ?
                \Yii::$app->authManager->checkAccess($this->id, $this->module->adminPermission) : false)
            || in_array($this->username, $this->module->admins);
    }


}

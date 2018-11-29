<?php

namespace app\models;

use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use dektrium\user\models\User as BaseUser;

class User extends BaseUser
{
//    public $id;
//    public $username;
//    public $email;
//    public $password_hash;
//    public $authKey;
//    public $accessToken;

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


}

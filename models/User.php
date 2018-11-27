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

//    private static $users = [
//        '100' => [
//            'id' => '100',
//            'username' => 'admin',
//            'password' => 'admin',
//            'authKey' => 'test100key',
//            'accessToken' => '100-token',
//        ],
//        '101' => [
//            'id' => '101',
//            'username' => 'demo',
//            'password' => 'demo',
//            'authKey' => 'test101key',
//            'accessToken' => '101-token',
//        ],
//    ];


//    /**
//     * {@inheritdoc}
//     */
//    public static function findIdentity($id)
//    {
//        return static::findOne(['id' => $id]);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public static function findIdentityByAccessToken($token, $type = null)
//    {
//        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
//    }
//
//    /**
//     * Finds user by username
//     *
//     * @param string $username
//     * @return static|null
//     */
//    public static function findByUsername($username)
//    {
//        return static::findOne(['username' => $username]);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function getId()
//    {
//        return $this->id;
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function getAuthKey()
//    {
//        return $this->authKey;
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function validateAuthKey($authKey)
//    {
//        return $this->authKey === $authKey;
//    }
//
//    /**
//     * Validates password
//     *
//     * @param string $password password to validate
//     * @return bool if password provided is valid for current user
//     */
//    public function validatePassword($password)
//    {
//        return \Yii::$app->security->validatePassword($password, $this->password_hash);
//    }
//
//    /**
//     * Generates password hash from password and sets it to the model
//     *
//     * @param string $password
//     */
//    public function setPassword($password)
//    {
//        $this->password_hash = \Yii::$app->security->generatePasswordHash($password);
//    }
//
//    /**
//     * Generates "remember me" authentication key
//     */
//    public function generateAuthKey()
//    {
//        $this->auth_key = \Yii::$app->security->generateRandomString();
//    }
}

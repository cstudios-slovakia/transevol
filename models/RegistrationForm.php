<?php
namespace app\models;

use yii\base\Model;

class RegistrationForm extends Model
{

    public $username;
    public $email;
    public $password;

    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['username', 'email', 'password'], 'required'],
        ];
    }

    public function registerUser(array $input)
    {
//        dd($this);
        $user = new User();
        $user->username = $this->username;
        $user->email    = $this->email;
        $user->setPassword($this->password);
        $saved = $user->save();
        dd($user,$saved);
        return $saved;

    }

}
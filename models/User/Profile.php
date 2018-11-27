<?php

namespace app\models\User;

use dektrium\user\models\Profile as BaseProfile;


class Profile extends BaseProfile
{
    public function rules()
    {
        return [
           'nameLength'  => ['name', 'string', 'max' => 255],
        ];
    }
}

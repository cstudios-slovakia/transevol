<?php

namespace app\models\userOverrides;

use dektrium\user\models\Profile as BaseProfile;


class Profile extends BaseProfile
{

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        // add field to scenarios
        $scenarios['create'][]   = 'first_name';
        $scenarios['create'][]   = 'last_name';
        $scenarios['create'][]   = 'phone_number';
        $scenarios['create'][]   = 'company_position';
        $scenarios['update'][]   = 'first_name';
        $scenarios['update'][]   = 'last_name';
        $scenarios['update'][]   = 'phone_number';
        $scenarios['update'][]   = 'company_position';
        return $scenarios;
    }

    public function rules()
    {
        $rules = parent::rules();

        $commonRules = [
            [['first_name','last_name','phone_number','company_position'],'required']
        ];

        return array_merge($rules, $commonRules);
    }
}

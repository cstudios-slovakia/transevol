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

//    public function rules()
//    {
//        $rules = parent::rules();
//        // add some rules
////        $rules['fieldRequired'] = ['field', 'required'];
////        $rules['fieldLength']   = ['field', 'string', 'max' => 10];
//
//        return $rules;
//    }

    public function rules()
    {
        return [
           'nameLength'  => ['name', 'string', 'max' => 255],
        ];
    }
}

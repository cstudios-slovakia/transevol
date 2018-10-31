<?php

namespace app\models;

use yii\base\Model;

class DriverForm extends Model
{
    public $lnch;
    public $wgfr;
    public $ldng;
    public $cslr;
    public $lnch_dual;
    public $wgfr_dual;
    public $ldng_dual;

    public function rules()
    {
        return [
            [['lnch','wgfr','ldng','cslr','lnch_dual','wgfr_dual','ldng_dual' ], 'required']
        ];

    }
}
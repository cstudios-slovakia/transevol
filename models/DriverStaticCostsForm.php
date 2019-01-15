<?php
namespace app\models;

use app\components\ModelTyped\Validators\StaticCostInputValidator;
use yii\base\Model;

class DriverStaticCostsForm extends Model
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
            [
                [
                    'lnch',
                    'wgfr',
                    'ldng',
                    'cslr',
                    'lnch_dual',
                    'wgfr_dual',
                    'ldng_dual',
                ],
                StaticCostInputValidator::className()
            ]
        ];

    }

}
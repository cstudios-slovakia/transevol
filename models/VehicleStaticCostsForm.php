<?php

namespace app\models;

use app\components\ModelTyped\Validators\StaticCostInputValidator;
use yii\base\Model;

class VehicleStaticCostsForm extends Model
{
    public $lsng;
    public $rdtx;
    public $srvs;
    public $otha;
    public $othb;
    public $pnmt;
    public $cmins;
    public $colins;
    public $cmrins;
    public $privtma;
    public $privtmb;
    public $privtmc;
    public $mnvhcl;
    public $mnvhcl_trlr_empty;
    public $mnvhcl_trlr_weight;

    public function rules()
    {
        return [
            ['lsng',StaticCostInputValidator::className(), 'skipOnEmpty' => false, 'skipOnError' => false],
            ['rdtx',StaticCostInputValidator::className(), 'skipOnEmpty' => false, 'skipOnError' => false],
            ['srvs',StaticCostInputValidator::className(), 'skipOnEmpty' => false, 'skipOnError' => false],
            ['otha',StaticCostInputValidator::className(), 'skipOnEmpty' => false, 'skipOnError' => false],
            ['othb',StaticCostInputValidator::className(), 'skipOnEmpty' => false, 'skipOnError' => false],
            ['pnmt',StaticCostInputValidator::className(), 'skipOnEmpty' => false, 'skipOnError' => false],
            ['cmins',StaticCostInputValidator::className(), 'skipOnEmpty' => false, 'skipOnError' => false],
            ['colins',StaticCostInputValidator::className(), 'skipOnEmpty' => false, 'skipOnError' => false],
            ['cmins',StaticCostInputValidator::className(), 'skipOnEmpty' => false, 'skipOnError' => false],
            ['cmrins',StaticCostInputValidator::className(), 'skipOnEmpty' => false, 'skipOnError' => false],
            ['privtma',StaticCostInputValidator::className(), 'skipOnEmpty' => false, 'skipOnError' => false],
            ['privtmb',StaticCostInputValidator::className(), 'skipOnEmpty' => false, 'skipOnError' => false],
            ['privtmc',StaticCostInputValidator::className(), 'skipOnEmpty' => false, 'skipOnError' => false],
            ['mnvhcl',StaticCostInputValidator::className(), 'skipOnEmpty' => false, 'skipOnError' => false],
            ['mnvhcl_trlr_empty',StaticCostInputValidator::className(), 'skipOnEmpty' => false, 'skipOnError' => false],
            ['mnvhcl_trlr_weight',StaticCostInputValidator::className(), 'skipOnEmpty' => false, 'skipOnError' => false],

        ];

    }



}
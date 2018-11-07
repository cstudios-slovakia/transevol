<?php

namespace app\models;

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
            [['lsng','rdtx','srvs','otha','othb','pnmt','cmins','colins','cmins','cmrins','privtma','privtmb','privtmc','mnvhcl','mnvhcl_trlr_empty','mnvhcl_trlr_weight' ], 'required']
        ];

    }
}
<?php

namespace app\models;

use yii\base\Model;

class CompanyStaticCostsForm extends Model
{
    public $mass_req_ins;
    public $mass_cls_ins;
    public $mass_cmr_ins;
    public $mass_acc_ins;
    public $adm_rntl;
    public $adm_prev;
    public $adm_buy_thnc;
    public $adm_disp_rbsh;

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mass_req_ins'  => 'PZP'
        ];
    }

    public function rules()
    {
        return [
            [
                [
                    'mass_req_ins',
                    'mass_cls_ins',
                    'mass_cmr_ins',
                    'mass_acc_ins',
                    'adm_rntl',
                    'adm_prev',
                    'adm_buy_thnc',
                    'adm_disp_rbsh'
                ], 'required'
            ]
        ];

    }
}
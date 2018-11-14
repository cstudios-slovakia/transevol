<?php

namespace app\models;

use Carbon\Carbon;
use yii\base\Model;
use yii\db\Expression;

class CompanyDynamicCostsForm extends Model
{

    public $value;
    public $cost_type;
    public $cost_name;
    public $action;
    public $id;
    public $companies_id;

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_DELETE = 'delete';

    public function rules()
    {
        return [
            [ 'action', 'required' ],
            [ [ 'value', 'cost_name', 'companies_id' ], 'required','on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE] ],
            [ [ 'cost_type' ], 'required','on' => [self::SCENARIO_CREATE] ],
            [ 'action', 'in', 'range' => [self::SCENARIO_CREATE,self::SCENARIO_UPDATE,self::SCENARIO_DELETE] ],
            [ 'id', 'required','on' => self::SCENARIO_DELETE ],
            [ [ 'id','companies_id' ], 'integer'],
            [ 'value' , 'number' ],
            [ [ 'cost_type', 'cost_name','action' ], 'string' ],
            [ ['id'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyDynamicCosts::className(), 'targetAttribute' => ['id' => 'id']],
            [ ['companies_id'], 'exist', 'skipOnError' => true, 'targetClass' => Companies::className(), 'targetAttribute' => ['companies_id' => 'id']],

        ];

    }

    public function deleteDynamicCost()
    {
        if(!isset($this->id)){
            return false;
        }
        return $dynamicCost = CompanyDynamicCosts::findOne(['id' => $this->id])->delete();
    }

    public function createDynamicCost()
    {
        $companyDynamicCosts    = new CompanyDynamicCosts();

        $companyDynamicCosts->load($this->toArray(),'');
        // TODO implement user defined Comapanies model
//        $companyDynamicCosts->companies_id     = $companyId;
        $companyDynamicCosts->frequency_datas_id     = FrequencyData::find()->orderBy(new Expression('rand()'))->one()->id;
        $companyDynamicCosts->units_id     = Units::find()->orderBy(new Expression('rand()'))->one()->id;
        $companyDynamicCosts->created_at = Carbon::now()->format('Y-m-d H:i:s');
        return $saved = $companyDynamicCosts->save();
    }


    public function updateDynamicCost()
    {
        $companyDynamicCosts = CompanyDynamicCosts::findOne(['id' => $this->id]);
        $companyDynamicCosts->value = $this->value;
        $companyDynamicCosts->cost_name = $this->cost_name;

        $companyDynamicCosts->frequency_datas_id     = FrequencyData::find()->orderBy(new Expression('rand()'))->one()->id;
        $companyDynamicCosts->units_id     = Units::find()->orderBy(new Expression('rand()'))->one()->id;

        return $companyDynamicCosts->update();
    }


}
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
    public $frequency_datas_id;

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_DELETE = 'delete';

    public function rules()
    {
        return [
            [ 'action', 'required' ],
            [ [ 'value', 'cost_name', 'companies_id', 'frequency_datas_id' ], 'required','on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE] ],
            [ [ 'cost_type' ], 'required','on' => [self::SCENARIO_CREATE] ],
            [ 'action', 'in', 'range' => [self::SCENARIO_CREATE,self::SCENARIO_UPDATE,self::SCENARIO_DELETE] ],
            [ 'id', 'required','on' => self::SCENARIO_DELETE ],
            [ [ 'id','companies_id','frequency_datas_id' ], 'integer'],
            [ 'value' , 'number' ],
            [ [ 'cost_type', 'cost_name','action' ], 'string' ],
            [ ['id'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyDynamicCosts::className(), 'targetAttribute' => ['id' => 'id']],
            [ ['companies_id'], 'exist', 'skipOnError' => true, 'targetClass' => Companies::className(), 'targetAttribute' => ['companies_id' => 'id']],
            [ ['frequency_datas_id'], 'exist', 'skipOnError' => true, 'targetClass' => FrequencyData::className(), 'targetAttribute' => ['frequency_datas_id' => 'id']],

        ];

    }

    public function deleteDynamicCost()
    {
        if(!isset($this->id)){
            return false;
        }

        $dynamicCost = CompanyDynamicCosts::findOne(['id' => $this->id]);

        $deleted = $dynamicCost->delete();

        return $deleted;
    }

    public function createDynamicCost()
    {
        $companyDynamicCosts    = new CompanyDynamicCosts();

        $companyDynamicCosts->load($this->toArray(),'');
        // TODO implement user defined Comapanies model
//        $companyDynamicCosts->companies_id     = $companyId;
//        $companyDynamicCosts->frequency_datas_id     = FrequencyData::find()->orderBy(new Expression('rand()'))->one()->id;
        $companyDynamicCosts->units_id     = Units::find()->orderBy(new Expression('rand()'))->one()->id;
        $companyDynamicCosts->created_at = Carbon::now()->format('Y-m-d H:i:s');
        return $saved = $companyDynamicCosts->save();
    }


    public function updateDynamicCost()
    {
        $companyDynamicCosts = CompanyDynamicCosts::findOne(['id' => $this->id]);
        $companyDynamicCosts->value = $this->value;
        $companyDynamicCosts->cost_name = $this->cost_name;

        $companyDynamicCosts->frequency_datas_id     = $this->frequency_datas_id;
        $companyDynamicCosts->units_id     = Units::find()->orderBy(new Expression('rand()'))->one()->id;
        $companyDynamicCosts->updated_at = Carbon::now()->format('Y-m-d H:i:s');

        return $companyDynamicCosts->update();
    }


}
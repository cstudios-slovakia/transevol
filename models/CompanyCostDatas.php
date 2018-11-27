<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "company_cost_datas".
 *
 * @property int $id
 * @property string $value
 * @property int $static_costs_id
 * @property int $companies_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Companies $companies
 * @property StaticCosts $staticCosts
 */
class CompanyCostDatas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company_cost_datas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value', 'static_costs_id', 'companies_id'], 'required'],
            [['value'], 'number'],
            [['static_costs_id', 'companies_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['companies_id'], 'exist', 'skipOnError' => true, 'targetClass' => Companies::className(), 'targetAttribute' => ['companies_id' => 'id']],
            [['static_costs_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaticCost::className(), 'targetAttribute' => ['static_costs_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'static_costs_id' => 'Static Costs ID',
            'companies_id' => 'Companies ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasOne(Companies::className(), ['id' => 'companies_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaticCosts()
    {
        return $this->hasOne(StaticCost::className(), ['id' => 'static_costs_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFrequencyData()
    {
        return $this->hasOne(FrequencyData::className(), ['id' => 'frequency_datas_id']);
    }
}

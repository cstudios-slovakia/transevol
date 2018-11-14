<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "company_dynamic_costs".
 *
 * @property int $id
 * @property string $value
 * @property string $cost_type
 * @property int $companies_id
 * @property int $frequency_datas_id
 * @property int $units_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Companies $companies
 * @property FrequencyData $frequencyDatas
 */
class CompanyDynamicCosts extends \yii\db\ActiveRecord
{
    const DYNAMIC_PERSONAL = 'perso';
    const DYNAMIC_OTHER = 'other';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company_dynamic_costs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value', 'cost_type','cost_name', 'companies_id', 'frequency_datas_id', 'units_id', 'created_at'], 'required'],
            [['value'], 'number'],
            [['companies_id', 'frequency_datas_id', 'units_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['cost_type'], 'string', 'max' => 5],
            [['companies_id'], 'exist', 'skipOnError' => true, 'targetClass' => Companies::className(), 'targetAttribute' => ['companies_id' => 'id']],
            [['frequency_datas_id'], 'exist', 'skipOnError' => true, 'targetClass' => FrequencyData::className(), 'targetAttribute' => ['frequency_datas_id' => 'id']],
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
            'cost_type' => 'Cost Type',
            'companies_id' => 'Companies ID',
            'frequency_datas_id' => 'Frequency Datas ID',
            'units_id' => 'Units ID',
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
    public function getFrequencyDatas()
    {
        return $this->hasOne(FrequencyData::className(), ['id' => 'frequency_datas_id']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "frequency_datas".
 *
 * @property int $id
 * @property string $frequency_name
 * @property string $frequency_value
 * @property int $frequency_groups_id
 * @property string $persec
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CompanyDynamicCosts[] $companyDynamicCosts
 * @property FrequencyGroups $frequencyGroups
 * @property StaticCosts[] $staticCosts
 */
class FrequencyData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'frequency_datas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['frequency_name', 'frequency_value', 'frequency_groups_id', 'persec', 'created_at'], 'required'],
            [['frequency_groups_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['frequency_name', 'persec'], 'string', 'max' => 100],
            [['frequency_value'], 'string', 'max' => 255],
            [['frequency_groups_id'], 'exist', 'skipOnError' => true, 'targetClass' => FrequencyGroups::className(), 'targetAttribute' => ['frequency_groups_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'frequency_name' => 'Frequency Name',
            'frequency_value' => 'Frequency Value',
            'frequency_groups_id' => 'Frequency Groups ID',
            'persec' => 'Persec',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyDynamicCosts()
    {
        return $this->hasMany(CompanyDynamicCost::className(), ['frequency_datas_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFrequencyGroups()
    {
        return $this->hasOne(FrequencyGroup::className(), ['id' => 'frequency_groups_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaticCosts()
    {
        return $this->hasMany(StaticCost::className(), ['frequency_datas_id' => 'id']);
    }
}

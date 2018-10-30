<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "driver_cost_datas".
 *
 * @property int $id
 * @property string $value
 * @property int $static_costs_id
 * @property int $drivers_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Drivers $drivers
 * @property StaticCosts $staticCosts
 */
class DriverCostDatas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'driver_cost_datas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value', 'static_costs_id', 'drivers_id', 'created_at'], 'required'],
            [['value'], 'number'],
            [['static_costs_id', 'drivers_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['drivers_id'], 'exist', 'skipOnError' => true, 'targetClass' => Drivers::className(), 'targetAttribute' => ['drivers_id' => 'id']],
            [['static_costs_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaticCosts::className(), 'targetAttribute' => ['static_costs_id' => 'id']],
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
            'drivers_id' => 'Drivers ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrivers()
    {
        return $this->hasOne(Drivers::className(), ['id' => 'drivers_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaticCosts()
    {
        return $this->hasOne(StaticCost::className(), ['id' => 'static_costs_id']);
    }
}

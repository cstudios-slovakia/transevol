<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vehicle_static_costs".
 *
 * @property int $id
 * @property string $value
 * @property int $static_costs_id
 * @property int $vehicles_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property StaticCosts $staticCosts
 * @property Vehicles $vehicles
 */
class VehicleStaticCosts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehicle_static_costs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value', 'static_costs_id', 'vehicles_id' ], 'required'],
            [['value'], 'number'],
            [['static_costs_id', 'vehicles_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['static_costs_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaticCost::className(), 'targetAttribute' => ['static_costs_id' => 'id']],
            [['vehicles_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehicles::className(), 'targetAttribute' => ['vehicles_id' => 'id']],
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
            'vehicles_id' => 'Vehicles ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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
    public function getVehicles()
    {
        return $this->hasOne(Vehicles::className(), ['id' => 'vehicles_id']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vehicle_types".
 *
 * @property int $id
 * @property string $vehicle_type_name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Vehicles[] $vehicles
 */
class VehicleTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehicle_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vehicle_type_name','type_shortly'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['vehicle_type_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vehicle_type_name' => 'Vehicle Type Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicles()
    {
        return $this->hasMany(Vehicles::className(), ['vehicle_types_id' => 'id']);
    }
}

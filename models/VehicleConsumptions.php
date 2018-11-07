<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vehicle_consumptions".
 *
 * @property int $id
 * @property string $empty_semi
 * @property string $empty_solo
 * @property string $empty_with_trailer
 * @property string $by_tons
 * @property int $adblue_percent
 * @property string $adblue_unit_price
 * @property string $fromdatetime
 * @property int $vehicles_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Vehicles $vehicles
 */
class VehicleConsumptions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehicle_consumptions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empty_semi', 'empty_solo', 'empty_with_trailer', 'by_tons', 'adblue_percent', 'adblue_unit_price', 'vehicles_id', 'created_at'], 'required'],
            [['empty_semi', 'empty_solo', 'empty_with_trailer', 'by_tons', 'adblue_unit_price'], 'number'],
            [['adblue_percent', 'vehicles_id'], 'integer'],
            [['fromdatetime', 'created_at', 'updated_at'], 'safe'],
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
            'empty_semi' => 'Empty Semi',
            'empty_solo' => 'Empty Solo',
            'empty_with_trailer' => 'Empty With Trailer',
            'by_tons' => 'By Tons',
            'adblue_percent' => 'Adblue Percent',
            'adblue_unit_price' => 'Adblue Unit Price',
            'fromdatetime' => 'Fromdatetime',
            'vehicles_id' => 'Vehicles ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicles()
    {
        return $this->hasOne(Vehicles::className(), ['id' => 'vehicles_id']);
    }
}

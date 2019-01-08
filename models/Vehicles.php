<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vehicles".
 *
 * @property int $id
 * @property string $ecv
 * @property int $companies_id
 * @property int $vehicle_types_id
 * @property int $emission_classes_id
 * @property string $weight
 * @property string $shaft
 * @property string $created_at
 * @property string $updated_at
 *
 * @property TransportVehicle[] $transportVehicles
 * @property VehicleConsumptions[] $vehicleConsumptions
 * @property VehicleStaticCosts[] $vehicleStaticCosts
 * @property Companies $companies
 * @property EmissionClasses $emissionClasses
 * @property VehicleTypes $vehicleTypes
 */
class Vehicles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehicles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ecv', 'vehicle_types_id', 'emission_classes_id', 'weight', 'shaft'], 'required',],

            [['companies_id', 'vehicle_types_id', 'emission_classes_id', 'weight', 'shaft'], 'integer',  'skipOnEmpty' => false],
            [['created_at', 'updated_at'], 'safe'],
            [['ecv'], 'string', 'max' => 100],
            [['companies_id'], 'exist', 'skipOnError' => true, 'targetClass' => Companies::className(), 'targetAttribute' => ['companies_id' => 'id']],
            [['emission_classes_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmissionClasses::className(), 'targetAttribute' => ['emission_classes_id' => 'id']],
            [['vehicle_types_id'], 'exist', 'skipOnError' => true, 'targetClass' => VehicleTypes::className(), 'targetAttribute' => ['vehicle_types_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ecv' => Yii::t('vehicle','ECV'),
            'companies_id' => Yii::t('vehicle','Companies ID'),
            'vehicle_types_id' => Yii::t('vehicle','Vehicle Types ID'),
            'emission_classes_id' => Yii::t('vehicle','Emission Classes ID'),
            'weight' => Yii::t('vehicle','Weight'),
            'shaft' => Yii::t('vehicle','Shaft'),
            'created_at' => Yii::t('common','Created At'),
            'updated_at' => Yii::t('common','Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransportVehicles()
    {
        return $this->hasMany(TransportVehicle::className(), ['vehicles_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleConsumptions()
    {
        return $this->hasMany(VehicleConsumptions::className(), ['vehicles_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleStaticCosts()
    {
        return $this->hasMany(VehicleStaticCosts::className(), ['vehicles_id' => 'id']);
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
    public function getEmissionClasses()
    {
        return $this->hasOne(EmissionClasses::className(), ['id' => 'emission_classes_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleTypes()
    {
        return $this->hasOne(VehicleTypes::className(), ['id' => 'vehicle_types_id']);
    }
}

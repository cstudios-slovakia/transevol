<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "drivers".
 *
 * @property int $id
 * @property string $driver_name
 * @property int $companies_id
 * @property string $email
 * @property string $phone
 * @property string $created_at
 * @property string $updated_at
 *
 * @property DriverCostDatas[] $driverCostDatas
 * @property Companies $companies
 * @property TransportDriver[] $transportDrivers
 */
class Drivers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'drivers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['driver_name', 'companies_id', 'email', 'phone', 'created_at'], 'required'],
            [['companies_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['driver_name'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['companies_id'], 'exist', 'skipOnError' => true, 'targetClass' => Companies::className(), 'targetAttribute' => ['companies_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'driver_name' => 'Driver Name',
            'companies_id' => 'Companies ID',
            'email' => 'Email',
            'phone' => 'Phone',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDriverCostDatas()
    {
        return $this->hasMany(DriverCostDatas::className(), ['drivers_id' => 'id']);
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
    public function getTransportDrivers()
    {
        return $this->hasMany(TransportDriver::className(), ['drivers_id' => 'id']);
    }
}

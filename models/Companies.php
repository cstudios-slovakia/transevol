<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "companies".
 *
 * @property int $id
 * @property string $company_name
 * @property string $email
 * @property string $phone
 * @property string $ico
 * @property string $dic
 * @property string $icdph
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CompanyCostDatas[] $companyCostDatas
 * @property CompanyDynamicCosts[] $companyDynamicCosts
 * @property Drivers[] $drivers
 * @property Places[] $places
 * @property Transports[] $transports
 * @property Vehicles[] $vehicles
 */
class Companies extends AppBasedActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'companies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_name', 'email', 'phone', 'ico', 'dic', 'icdph'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['company_name'], 'string', 'max' => 45],
            [['email'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 20],
            [['ico', 'dic', 'icdph'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_name' => 'Company Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'ico' => 'Ico',
            'dic' => 'Dic',
            'icdph' => 'Icdph',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyCostDatas()
    {
        return $this->hasMany(CompanyCostDatas::className(), ['companies_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyDynamicCosts()
    {
        return $this->hasMany(CompanyDynamicCosts::className(), ['companies_id' => 'id']);
    }

    public function getCompanyPersonalDynamicCosts()
    {
        return $this->hasMany(CompanyDynamicPersonalCosts::className(), ['companies_id' => 'id']);
    }

    public function getCompanyOtherDynamicCosts()
    {
        return $this->hasMany(CompanyDynamicOtherCosts::className(), ['companies_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrivers()
    {
        return $this->hasMany(Drivers::className(), ['companies_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaces()
    {
        return $this->hasMany(Places::className(), ['companies_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransports()
    {
        return $this->hasMany(Transports::className(), ['companies_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicles()
    {
        return $this->hasMany(Vehicles::className(), ['companies_id' => 'id']);
    }
}

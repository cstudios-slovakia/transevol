<?php

namespace app\models;

use app\support\helpers\LoggedInUserTrait;
use Yii;

/**
 * This is the model class for table "timeline_driver".
 *
 * @property int $id
 * @property string $driver_record_from
 * @property string $driver_record_until
 * @property int $companies_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Companies $companies
 */
class TimelineDriver extends \yii\db\ActiveRecord
{
    const SCENARIO_START = 'start';
    const SCENARIO_FINNISH = 'finnish';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'timeline_driver';
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_START => ['driver_record_from','companies_id','drivers_id'],
            self::SCENARIO_FINNISH => ['driver_record_until','companies_id','drivers_id'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['driver_record_from', 'driver_record_until','drivers_id'], 'required'],
            [['driver_record_from', 'driver_record_until', 'created_at', 'updated_at'], 'safe'],
            [['companies_id','drivers_id'], 'integer'],
            [['companies_id'], 'exist', 'skipOnError' => true, 'targetClass' => Companies::className(), 'targetAttribute' => ['companies_id' => 'id']],
            [['drivers_id'], 'exist', 'skipOnError' => true, 'targetClass' => Drivers::className(), 'targetAttribute' => ['drivers_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'driver_record_from' => Yii::t('app', 'Driver Record From'),
            'driver_record_until' => Yii::t('app', 'Driver Record Until'),
            'companies_id' => Yii::t('app', 'Companies ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
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
    public function getDrivers()
    {
        return $this->hasOne(Drivers::className(), ['id' => 'drivers_id']);
    }

    public function getVehicles()
    {
        return $this->hasOne(Vehicles::className(),['id' => 'vehicle_id'])
            ->viaTable('timeline_driver__vehicle',['timeline_driver_id'=> 'id']);
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $company = LoggedInUserTrait::loggedInUserCompany();

        $this->setAttribute('companies_id', $company->id);

        return true;
    }

    public static function find()
    {
        $find = parent::find();

        $company = LoggedInUserTrait::loggedInUserCompany();

        $find->andWhere(['timeline_driver.companies_id' => $company->id]);

        return $find;
    }
}

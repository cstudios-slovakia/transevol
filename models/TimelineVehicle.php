<?php

namespace app\models;

use app\support\helpers\LoggedInUserTrait;
use Yii;

/**
 * This is the model class for table "timeline_vehicle".
 *
 * @property int $id
 * @property string $vehicle_record_from
 * @property string $vehicle_record_until
 * @property int $companies_id
 * @property int $vehicle_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Companies $companies
 * @property Vehicles $vehicle
 */
class TimelineVehicle extends \yii\db\ActiveRecord
{
    CONST TIMELINE_ITEM_GROUP_NUMBER = 3;
    CONST TIMELINE_ITEM_ID_PREDIX = 'v_';




    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'timeline_vehicle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vehicle_record_from', 'vehicle_id'], 'required'],
            [['vehicle_record_from', 'vehicle_record_until', 'created_at', 'updated_at'], 'safe'],
            [['companies_id', 'vehicle_id'], 'integer'],
            [['companies_id'], 'exist', 'skipOnError' => true, 'targetClass' => Companies::className(), 'targetAttribute' => ['companies_id' => 'id']],
            [['vehicle_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehicles::className(), 'targetAttribute' => ['vehicle_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'vehicle_record_from' => Yii::t('app', 'Vehicle Record From'),
            'vehicle_record_until' => Yii::t('app', 'Vehicle Record Until'),
            'companies_id' => Yii::t('app', 'Companies ID'),
            'vehicle_id' => Yii::t('app', 'Vehicle ID'),
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
    public function getVehicle()
    {
        return $this->hasOne(Vehicles::className(), ['id' => 'vehicle_id']);
    }

    public function getTimelineVehicle()
    {
        return $this->hasOne(Vehicles::className(),['id' => 'vehicle_id'])
            ->viaTable('timeline_vehicle__vehicle',['timeline_vehicle_id'=> 'id']);

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

        $find->andWhere(['timeline_vehicle.companies_id' => $company->id]);

        return $find;
    }
}

<?php

namespace app\models;

use app\support\helpers\LoggedInUserTrait;
use Carbon\Carbon;
use Yii;

/**
 * This is the model class for table "goings".
 *
 * @property int $id
 * @property string $going_from
 * @property string $going_until
 * @property int $companies_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Companies $companies
 */
class Goings extends AppBasedActiveRecord
{
    const SCENARIO_START = 'start';
    const SCENARIO_FINNISH = 'finnish';
    CONST TIMELINE_ITEM_GROUP_NUMBER = 1;
    CONST TIMELINE_ITEM_ID_PREDIX = 'g_';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goings';
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();

        return $scenarios + [
            self::SCENARIO_START => ['going_from','companies_id'],
            self::SCENARIO_FINNISH => ['going_until','companies_id'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['going_from', 'going_until'], 'required'],
            [['going_from', 'going_until', 'created_at', 'updated_at'], 'safe'],
            [['companies_id'], 'integer'],
            [['companies_id'], 'exist', 'skipOnError' => true, 'targetClass' => Companies::className(), 'targetAttribute' => ['companies_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'going_from' => Yii::t('app', 'Going From'),
            'going_until' => Yii::t('app', 'Going Until'),
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

    public function getVehicles()
    {
        return $this->hasOne(Vehicles::className(),['id' => 'vehicle_id'])
            ->viaTable('going__vehicle',['going_id'=> 'id']);
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

    public function getSpentHours()
    {
        $from = $this->getAttribute('going_from');
        $until = $this->getAttribute('going_until');

        if (! $from || !$until){
            return 0;
        }
        $intervalFrom = Carbon::createFromFormat('Y-m-d H:i:s',$from);
        $intervalUntil = Carbon::createFromFormat('Y-m-d H:i:s',$until);

        $difference  = $intervalFrom->diffAsCarbonInterval($intervalUntil);

        return $difference->hours .':'.$difference->minutes;
    }
}

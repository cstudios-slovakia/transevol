<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "places".
 *
 * @property int $id
 * @property string $place_name
 * @property string $position
 * @property int $companies_id
 * @property int $countries_id
 * @property int $addresses_id
 * @property int $place_types_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Addresses $addresses
 * @property Companies $companies
 * @property Countries $countries
 * @property PlaceTypes $placeTypes
 * @property TransportPlace[] $transportPlaces
 */
class Places extends AppBasedActiveRecord
{
    const SCENARIO_LOADING  = 'loading';
    const SCENARIO_TOLL     = 'toll';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'places';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['place_name', 'place_types_id'], 'required'],
            [['position'], 'required', 'on' => [self::SCENARIO_LOADING,self::SCENARIO_TOLL]],

            [['companies_id', 'countries_id', 'addresses_id', 'place_types_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['place_name', 'position'], 'string', 'max' => 255],
            [['addresses_id'], 'exist', 'skipOnError' => true, 'targetClass' => Addresses::className(), 'targetAttribute' => ['addresses_id' => 'id']],
            [['companies_id'], 'exist', 'skipOnError' => true, 'targetClass' => Companies::className(), 'targetAttribute' => ['companies_id' => 'id']],
            [['countries_id'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::className(), 'targetAttribute' => ['countries_id' => 'id']],
            [['place_types_id'], 'exist', 'skipOnError' => true, 'targetClass' => PlaceTypes::className(), 'targetAttribute' => ['place_types_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'place_name' => Yii::t('place','Place name'),
            'position' => Yii::t('place','Position'),
            'companies_id' => Yii::t('place','Companies id'),

            'countries_id' => Yii::t('place','Countries id'),
            'addresses_id' => Yii::t('place','Addresses id'),
            'place_types_id' => Yii::t('place','Place types id'),
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasOne(Addresses::className(), ['id' => 'addresses_id']);
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
    public function getCountries()
    {
        return $this->hasOne(Countries::className(), ['id' => 'countries_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaceTypes()
    {
        return $this->hasOne(PlaceTypes::className(), ['id' => 'place_types_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransportPlaces()
    {
        return $this->hasMany(TransportPlace::className(), ['places_id' => 'id']);
    }
}

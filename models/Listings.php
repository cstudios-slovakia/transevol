<?php

namespace app\models;

use app\support\helpers\LoggedInUserTrait;
use Yii;

/**
 * This is the model class for table "listings".
 *
 * @property int $id
 * @property string $place_name
 * @property int $companies_id
 * @property string $email
 * @property string $phone
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
 */
class Listings extends AppBasedActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'listings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['place_name', 'place_types_id'], 'required'],
            [['companies_id', 'countries_id', 'place_types_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['place_name', 'email'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
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
            'place_name' => Yii::t('listing','Názov miesta'),
            'companies_id' => Yii::t('listing','Názov firmy'),
            'email' =>  Yii::t('listing','E-mail'),
            'phone' => Yii::t('listing','Tel.číslo'),
            'countries_id' =>  Yii::t('listing','Štát'),
            'addresses_id' =>  Yii::t('listing','Adresa'),
            'place_types_id' =>  Yii::t('listing','Typ miesta'),
            'created_at' =>  Yii::t('common','Dátum vytvorenia'),
            'updated_at' => Yii::t('common','Dátum aktualizácie'),
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

    public function getServicePlaceTypes()
    {
        return $this->hasOne(PlaceTypes::className(), ['id' => 'place_types_id'])
            ->where('placetype_name = :placetype_name', [':placetype_name' => 'services']);

    }
    /**
     * {@inheritdoc}
     * @return ActiveQuery the newly created [[ActiveQuery]] instance.
     */
    public static function find()
    {
        $find = parent::find();

        $company = LoggedInUserTrait::loggedInUserCompany();

        $find->andWhere(['companies_id' => $company->id]);

        return $find;
    }
}

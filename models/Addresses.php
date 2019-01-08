<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "addresses".
 *
 * @property int $id
 * @property string $city
 * @property string $street
 * @property string $zip
 * @property int $countries_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Countries $countries
 * @property Places[] $places
 */
class Addresses extends AppBasedActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'addresses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city', 'street', 'zip', 'countries_id' ], 'required'],
            [['countries_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['city'], 'string', 'max' => 100],
            [['street'], 'string', 'max' => 255],
            [['zip'], 'string', 'max' => 50],
            [['countries_id'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::className(), 'targetAttribute' => ['countries_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city' => Yii::t('address','Mesto'),
            'street' =>Yii::t('address','Ulica'),
            'zip' => Yii::t('address','PSČ'),
            'countries_id' => Yii::t('address','Štát'),
            'created_at' => Yii::t('common','Dátum vytvorenia'),
            'updated_at' => Yii::t('common','Dátum aktualizácie'),
        ];
    }

    /**
     * Simple implementation for concatination our address.
     *
     * @param array $order
     * @return string
     */
    public function getFullAddress(array $order = []) : string
    {
        if(!empty($order)){
            $address    = [];
            foreach ($order as $column){
                $address[] = $this->{$column};
            }
            return implode(', ',$address);
        }

        return $this->street .', '.$this->zip . ' ' . $this->city;
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
    public function getPlaces()
    {
        return $this->hasMany(Places::className(), ['addresses_id' => 'id']);
    }
}

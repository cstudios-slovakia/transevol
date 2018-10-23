<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "place_types".
 *
 * @property int $id
 * @property string $placetype_name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Places[] $places
 */
class PlaceTypes extends AppBasedActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'place_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['placetype_name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['placetype_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'placetype_name' => 'Placetype Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaces()
    {
        return $this->hasMany(Places::className(), ['place_types_id' => 'id']);
    }

}

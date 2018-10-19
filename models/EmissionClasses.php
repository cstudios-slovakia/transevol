<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "emission_classes".
 *
 * @property int $id
 * @property string $emission_name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Vehicles[] $vehicles
 */
class EmissionClasses extends AppBasedActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emission_classes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emission_name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['emission_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'emission_name' => 'Emission Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicles()
    {
        return $this->hasMany(Vehicles::className(), ['emission_classes_id' => 'id']);
    }
}

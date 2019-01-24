<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transporter_parts".
 *
 * @property int $id
 * @property string $event_time
 * @property int $load_meter
 * @property int $load_weight
 * @property string $part_other_cost
 * @property int $places_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property TransporterContents[] $transporterContents
 * @property Places $places
 */
class TransporterParts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transporter_parts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_time', 'places_id'], 'required'],
            [['event_time', 'created_at', 'updated_at', 'created_at'], 'safe'],
            [['load_meter', 'load_weight', 'places_id'], 'integer'],
            [['part_other_cost'], 'number'],
            [['places_id'], 'exist', 'skipOnError' => true, 'targetClass' => Places::className(), 'targetAttribute' => ['places_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'event_time' => Yii::t('app', 'Event Time'),
            'load_meter' => Yii::t('app', 'Load Meter'),
            'load_weight' => Yii::t('app', 'Load Weight'),
            'part_other_cost' => Yii::t('app', 'Part Other Cost'),
            'places_id' => Yii::t('app', 'Places ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransporterContents()
    {
        return $this->hasMany(TransporterContents::className(), ['transporter_parts_id' => 'id']);
    }

    public function getTransporter()
    {
        return $this->hasMany(Transporter::className(), ['id' => 'transporter_id'])
            ->via('transporterContents');

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaces()
    {
        return $this->hasOne(Places::className(), ['id' => 'places_id']);
    }
}

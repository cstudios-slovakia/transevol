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
            'id' => Yii::t('transporter_parts', 'ID'),
            'event_time' => Yii::t('transporter_parts', 'Event Time'),
            'load_meter' => Yii::t('transporter_parts', 'Load Meter'),
            'load_weight' => Yii::t('transporter_parts', 'Load Weight'),
            'part_other_cost' => Yii::t('transporter_parts', 'Part Other Cost'),
            'places_id' => Yii::t('transporter_parts', 'Places ID'),
            'created_at' => Yii::t('transporter_parts', 'Created At'),
            'updated_at' => Yii::t('transporter_parts', 'Updated At'),
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaceTypes()
    {
        return $this->hasOne(PlaceTypes::className(), ['id' => 'place_types_id'])->via('places');
    }

}

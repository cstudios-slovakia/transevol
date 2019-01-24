<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transporter_contents".
 *
 * @property int $transporter_id
 * @property int $transporter_parts_id
 * @property string $created_at
 *
 * @property Transporter $transporter
 * @property TransporterParts $transporterParts
 */
class TransporterContents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transporter_contents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['transporter_id', 'transporter_parts_id'], 'required'],
            [['transporter_id', 'transporter_parts_id'], 'integer'],
            [['created_at', 'created_at'], 'safe'],
            [['transporter_id'], 'exist', 'skipOnError' => true, 'targetClass' => Transporter::className(), 'targetAttribute' => ['transporter_id' => 'id']],
            [['transporter_parts_id'], 'exist', 'skipOnError' => true, 'targetClass' => TransporterParts::className(), 'targetAttribute' => ['transporter_parts_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'transporter_id' => Yii::t('app', 'Transporter ID'),
            'transporter_parts_id' => Yii::t('app', 'Transporter Parts ID'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransporter()
    {
        return $this->hasOne(Transporter::className(), ['id' => 'transporter_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransporterParts()
    {
        return $this->hasOne(TransporterParts::className(), ['id' => 'transporter_parts_id']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "frequency_groups".
 *
 * @property int $id
 * @property string $frequency_group_name
 * @property string $sorting_number
 * @property string $created_at
 * @property string $updated_at
 *
 * @property FrequencyDatas[] $frequencyDatas
 */
class FrequencyGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'frequency_groups';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['frequency_group_name', 'sorting_number', 'created_at'], 'required'],
            [['sorting_number'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['frequency_group_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'frequency_group_name' => 'Frequency Group Name',
            'sorting_number' => 'Sorting Number',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFrequencyDatas()
    {
        return $this->hasMany(FrequencyDatas::className(), ['frequency_groups_id' => 'id']);
    }
}

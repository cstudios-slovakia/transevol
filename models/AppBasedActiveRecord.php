<?php

namespace app\models;

use Carbon\Carbon;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class AppBasedActiveRecord extends \yii\db\ActiveRecord
{


    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function getLocaleCreatedAt(string $format = 'd.m.Y H:i') : string
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format($format);
    }

}
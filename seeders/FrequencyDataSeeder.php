<?php

namespace app\seeders;

use app\models\FrequencyGroup;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class FrequencyDataSeeder extends Seeder
{
    public function run()
    {

        $freqGroup = function (string $type){
            return FrequencyGroup::find()->where(['frequency_group_name' => $type])->one()->id;
        };

        $frequencies    = [
            [1, 'daily', 24, call_user_func($freqGroup,'time'), 60],
            [2, 'monthly', 720, call_user_func($freqGroup,'time'), 60],
            [3, 'yearly', 8000, call_user_func($freqGroup,'time'), 60],
            [4, 'km', 8000, call_user_func($freqGroup,'length'), 60],
        ];

        $columnConfig   = [
            false, 'frequency_name', 'frequency_value', 'frequency_groups_id', 'persec'
        ];

        $this->table('frequency_datas')->data($frequencies,$columnConfig)->rowQuantity(count($frequencies));

    }
}
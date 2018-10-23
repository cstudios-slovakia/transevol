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
            [1, 'daily', 24 * 60, call_user_func($freqGroup,'time'), 'i'],
            [2, 'monthly', 43829, call_user_func($freqGroup,'time'), 'i'],
            [3, 'yearly', 525949, call_user_func($freqGroup,'time'), 'i'],
            [4, 'km', 1, call_user_func($freqGroup,'length'), 'km'],
        ];

        $columnConfig   = [
            false, 'frequency_name', 'frequency_value', 'frequency_groups_id', 'persec'
        ];

        $this->table('frequency_datas')->data($frequencies,$columnConfig)->rowQuantity(count($frequencies));

    }
}
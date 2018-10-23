<?php

namespace app\seeders;

use app\models\FrequencyData;
use app\models\Units;
use Faker\Factory;
use Faker\Generator;
use yii\db\Expression;


class StaticCostSeeder extends Seeder
{
    public function run()
    {

        $periodFreq = function(string $period){
            $frequencyData = FrequencyData::find()->where(['frequency_name' => $period]);
            return $frequencyData->one()->id;
        };

        $unitId = function(string $unit){
            $q = Units::find()->where(['unit_name' => $unit]);
            return $q->one()->id;
        };

        $array =
            [
                [1,'luncheon_voucher','lnch','driver',call_user_func($periodFreq,'daily'),call_user_func($unitId,'eur')],
                [2,'wage_for_km','wgfr','driver',call_user_func($periodFreq,'km'),call_user_func($unitId,'eur')],

            ];
        $columnConfig = [false,'cost_name','short_name','cost_section','frequency_datas_id','units_id'];

        $this->table('static_costs')->data($array, $columnConfig)->rowQuantity(2);


    }
}
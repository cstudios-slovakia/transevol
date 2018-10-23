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

        $records =
            [
                [1,'luncheon_voucher','lnch','driver',call_user_func($periodFreq,'daily'),call_user_func($unitId,'eur')],
                [2,'wage_for_km','wgfr','driver',call_user_func($periodFreq,'km'),call_user_func($unitId,'eur')],
                [3,'loadings','ldng','driver',call_user_func($periodFreq,'daily'),call_user_func($unitId,'eur')],
                [4,'constant_salary','cslr','driver',call_user_func($periodFreq,'monthly'),call_user_func($unitId,'eur')],
                [5,'luncheon_voucher_dual','lnch_dual','driver',call_user_func($periodFreq,'daily'),call_user_func($unitId,'eur')],
                [6,'wage_for_km_dual','wgfr_dual','driver',call_user_func($periodFreq,'km'),call_user_func($unitId,'eur')],
                [7,'loadings_dual','ldng_dual','driver',call_user_func($periodFreq,'daily'),call_user_func($unitId,'eur')],

            ];
        $columnConfig = [false,'cost_name','short_name','cost_section','frequency_datas_id','units_id'];

        $this->table('static_costs')->data($records, $columnConfig)->rowQuantity(count($records));


    }
}
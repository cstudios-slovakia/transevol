<?php

namespace app\seeders;



use app\models\Companies;
use app\models\CompanyDynamicCosts;
use app\models\CompanyStaticCostQuery;
use app\support\FrequencyDataBuilder;
use Carbon\Carbon;
use Faker\Factory;

class CompanyDynamicCostsSeeder extends Seeder
{
    public function run()
    {

        $faker = Factory::create();
        $companies = Companies::find()->all();

        $valueGenerator = function () use ($faker){
            return $faker->randomFloat(2,5,3333);
        };

        $companyPersonalDynamicCostsAmount = function () use($faker){
            return $faker->numberBetween(2,7);
        };
        $companyOtherDynamicCostsAmount = function () use($faker){
            return $faker->numberBetween(1,4);
        };

        $frequencyDatas     = FrequencyDataBuilder::makeType('time')->dropDownListOptions();
        $frequencyDatasIds = array_keys($frequencyDatas);

        $frequencyDatasIdGenerator  = function () use($faker, $frequencyDatasIds){
            return $faker->randomElement($frequencyDatasIds);
        };

        $costNameGenerator = function () use ($faker) {
            return $faker->text(99);
        };

        $personalCostType = CompanyDynamicCosts::DYNAMIC_PERSONAL;
        $otherCostType = CompanyDynamicCosts::DYNAMIC_OTHER;

        $columnConfig   = [false, 'cost_name', 'value', 'cost_type', 'companies_id', 'created_at', 'frequency_datas_id'];
        $records    = [];
        foreach ($companies as $company){

            $generatePersonal = $faker->boolean(90);
            if($generatePersonal){
                $times = call_user_func($companyPersonalDynamicCostsAmount);
                for ($i = 0; $i < $times; $i++){
                    $records[]  = [
                        false,call_user_func($costNameGenerator),call_user_func($valueGenerator), $personalCostType, $company->id, Carbon::now()->format('Y-m-d H:i:s'), call_user_func($frequencyDatasIdGenerator)
                    ];
                }
            }
            $generateOther = $faker->boolean(90);
            if ($generateOther){
                $times = call_user_func($companyOtherDynamicCostsAmount);
                for ($i = 0; $i <  $times; $i++){
                    $records[]  = [
                        false,call_user_func($costNameGenerator),call_user_func($valueGenerator), $otherCostType, $company->id, Carbon::now()->format('Y-m-d H:i:s'), call_user_func($frequencyDatasIdGenerator)
                    ];
                }
            }


        }

        $this->table('company_dynamic_costs')->data($records,$columnConfig)->rowQuantity(count($records));

    }

}
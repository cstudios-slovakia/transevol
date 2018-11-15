<?php

namespace app\seeders;



use app\models\Companies;
use app\models\CompanyStaticCostQuery;
use app\support\FrequencyDataBuilder;
use Carbon\Carbon;
use Faker\Factory;

class CompanyStaticCostsSeeder extends Seeder
{
    public function run()
    {
        $companyStaticCosts     = CompanyStaticCostQuery::find()->all();

        $faker = Factory::create();

        $valueGenerator = function () use ($faker){
            return $faker->randomFloat(2,5,3333);
        };

        $frequencyDatas     = FrequencyDataBuilder::makeType('time')->dropDownListOptions();
        $frequencyDatasIds = array_keys($frequencyDatas);

        $frequencyDatasIdGenerator  = function () use($faker, $frequencyDatasIds){
            return $faker->randomElement($frequencyDatasIds);
        };

        $companies = Companies::find()->all();
        $columnConfig   = [false, 'value', 'static_costs_id', 'companies_id', 'created_at', 'frequency_datas_id'];
        $records    = [];
        foreach ($companies as $company){

            foreach ($companyStaticCosts as $companyStaticCost){
                $records[]  = [
                    false,call_user_func($valueGenerator), $companyStaticCost->id, $company->id, Carbon::now()->format('Y-m-d H:i:s'), call_user_func($frequencyDatasIdGenerator)
                ];
            }

        }

        $this->table('company_cost_datas')->data($records,$columnConfig)->rowQuantity(count($records));

    }

}
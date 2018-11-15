<?php

namespace app\seeders;



use app\models\Vehicles;
use app\models\VehicleStaticCost;
use app\support\FrequencyDataBuilder;
use Carbon\Carbon;
use Faker\Factory;

class VehicleStaticCostsSeeder extends Seeder
{
    public function run()
    {
        $vehicleStaticCosts     = VehicleStaticCost::find()->all();

        $faker = Factory::create();

        $valueGenerator = function () use ($faker){
            return $faker->randomFloat(2,5,3333);
        };

        $frequencyDatas     = FrequencyDataBuilder::makeType('time')->dropDownListOptions();
        $frequencyDatasIds = array_keys($frequencyDatas);

        $frequencyDatasIdGenerator  = function () use($faker, $frequencyDatasIds){
            return $faker->randomElement($frequencyDatasIds);
        };

        $vehicles = Vehicles::find()->all();
        $columnConfig   = [false, 'value', 'static_costs_id', 'vehicles_id', 'created_at','frequency_datas_id'];
        $records    = [];
        foreach ($vehicles as $vehicle){

            foreach ($vehicleStaticCosts as $vehicleStaticCost){
                $records[]  = [
                    false,call_user_func($valueGenerator), $vehicleStaticCost->id, $vehicle->id, Carbon::now()->format('Y-m-d H:i:s'), call_user_func($frequencyDatasIdGenerator)
                ];
            }

        }

        $this->table('vehicle_static_costs')->data($records,$columnConfig)->rowQuantity(count($records));

    }

}
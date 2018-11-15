<?php

namespace app\seeders;



use app\models\Drivers;
use app\models\DriverStaticCost;
use app\models\Vehicles;
use app\models\VehicleStaticCost;
use app\support\FrequencyDataBuilder;
use Carbon\Carbon;
use Faker\Factory;

class DriverStaticCostsSeeder extends Seeder
{
    public function run()
    {
//        $vehicleStaticCosts     = VehicleStaticCost::find()->all();
        $driverStaticCosts = DriverStaticCost::find()->all();
        $faker = Factory::create();

        $valueGenerator = function () use ($faker){
            return $faker->randomFloat(2,5,3333);
        };

        $frequencyTimeDatas     = FrequencyDataBuilder::makeType('time')->dropDownListOptions();
        $frequencyTimeDatasIds = array_keys($frequencyTimeDatas);

        $frequencyDatasIdGenerator  = function () use($faker, $frequencyTimeDatasIds){
            return $faker->randomElement($frequencyTimeDatasIds);
        };

//        $vehicles = Vehicles::find()->all();
        $drivers = Drivers::find()->all();
        $columnConfig   = [false, 'value', 'static_costs_id', 'drivers_id', 'created_at','frequency_datas_id'];
        $records    = [];
        foreach ($drivers as $driver){

            foreach ($driverStaticCosts as $driverStaticCost){
                $records[]  = [
                    false,call_user_func($valueGenerator), $driverStaticCost->id, $driver->id, Carbon::now()->format('Y-m-d H:i:s'), call_user_func($frequencyDatasIdGenerator)
                ];
            }

        }

        $this->table('driver_cost_datas')->data($records,$columnConfig)->rowQuantity(count($records));

    }

}
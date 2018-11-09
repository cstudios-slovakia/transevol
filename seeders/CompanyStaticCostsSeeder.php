<?php

namespace app\seeders;



use app\models\Vehicles;
use app\models\VehicleStaticCost;
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

        $vehicles = Vehicles::find()->all();
        $columnConfig   = [false, 'value', 'static_costs_id', 'vehicles_id', 'created_at'];
        $records    = [];
        foreach ($vehicles as $vehicle){

            foreach ($vehicleStaticCosts as $vehicleStaticCost){
                $records[]  = [
                    false,call_user_func($valueGenerator), $vehicleStaticCost->id, $vehicle->id, Carbon::now()->format('Y-m-d H:i:s')
                ];
            }

        }

        $this->table('vehicle_static_costs')->data($records,$columnConfig)->rowQuantity(count($records));

    }

}
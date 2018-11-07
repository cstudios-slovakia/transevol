<?php

namespace app\seeders;

use app\models\Companies;
use app\models\EmissionClasses;
use app\models\VehicleTypes;
use Carbon\Carbon;
use yii\db\Expression;

class VehicleSeeder extends Seeder
{
    public function run()
    {

        $generateEcv    = function () {
          return $this->faker->creditCardNumber;
        };

        $associateRandomCompany   = Companies::find()->orderBy(new Expression('rand()'))->limit(1)->one();

        $associateRandomVehicleTypes    = function ($onlyId = false){
            $vehicleType = VehicleTypes::find()->orderBy(new Expression('rand()'))->one();

            if($onlyId){
                return $vehicleType->id;
            }

            return $vehicleType;
        };

        $associateRandomEmissions   = function ($onlyId = false){
            $model = EmissionClasses::find()->orderBy(new Expression('rand()'))->one();

            if($onlyId){
                return $model->id;
            }

            return $model;
        };


        $this->table('vehicles')->columns([
            'id',
            'ecv'   => call_user_func($generateEcv),
            'companies_id'  => $associateRandomCompany->id,
            'vehicle_types_id'  => call_user_func($associateRandomVehicleTypes,true),
            'emission_classes_id'   => call_user_func($associateRandomEmissions,true),
            'weight'    => $this->faker->numberBetween(40000,90000),
            'shaft'     => $this->faker->numberBetween(6,9),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ])->rowQuantity(20);
    }
}
<?php

namespace app\seeders;

use app\models\Companies;
use Carbon\Carbon;
use yii\db\Expression;

class DriverSeeder extends Seeder
{
    public function run()
    {
        $company    = function (){
            return Companies::find()->orderBy(new Expression('rand()'))->one()->id;
        };

        $this->table('drivers')->columns([
            'id', //automatic pk
            'driver_name'=>$this->faker->name,
            'companies_id'=>call_user_func($company),
            'email'=>$this->faker->email,
            'phone'=>$this->faker->phoneNumber,
            'created_at'    => Carbon::now()->toDateTimeString()
        ])->rowQuantity(6);

    }
}
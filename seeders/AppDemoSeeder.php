<?php

namespace app\seeders;



class AppDemoSeeder extends Seeder
{
    public function __call($name, $arguments)
    {
        if ($name === 'seeding') {


            \Yii::$app->runAction('seed/make',['resolvable'=>'UnitSeeder']);
            \Yii::$app->runAction('seed/make',['resolvable'=>'FrequencyGroupSeeder']);
            \Yii::$app->runAction('seed/make',['resolvable'=>'FrequencyDataSeeder']);
            \Yii::$app->runAction('seed/make',['resolvable'=>'PlaceTypeSeeder']);
            \Yii::$app->runAction('seed/make',['resolvable'=>'VehicleTypeSeeder']);
            \Yii::$app->runAction('seed/make',['resolvable'=>'EmissionsSeeder']);
            \Yii::$app->runAction('seed/make',['resolvable'=>'CountriesSeeder']);
            \Yii::$app->runAction('seed/make',['resolvable'=>'CompanySeeder']);
            \Yii::$app->runAction('seed/make',['resolvable'=>'StaticCostSeeder']);
            \Yii::$app->runAction('seed/make',['resolvable'=>'VehicleSeeder']);
            \Yii::$app->runAction('seed/make',['resolvable'=>'VehicleStaticCostsSeeder']);
            \Yii::$app->runAction('seed/make',['resolvable'=>'DriverSeeder']);
            \Yii::$app->runAction('seed/make',['resolvable'=>'DriverStaticCostsSeeder']);
            \Yii::$app->runAction('seed/make',['resolvable'=>'CompanyStaticCostsSeeder']);
            \Yii::$app->runAction('seed/make',['resolvable'=>'CompanyDynamicCostsSeeder']);

        }
    }
}
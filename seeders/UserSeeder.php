<?php

namespace app\seeders;



use app\models\Companies;
use app\models\userOverrides\RegistrationForm;
use Faker\Factory;

class UserSeeder extends Seeder
{
    const TABLENAME = 'user';

    public function run()
    {
        $users = [];
        $authAssignment = [];
        $faker = Factory::create();
        $email = function () use ($faker){
            return $faker->email;
        };

        $userName = function () use ($faker) {
            return $faker->userName;
        };

        $companies = Companies::find()->all();

        $queryLastId = \Yii::$app->db->createCommand('SELECT max(id) as lastId FROM '.self::TABLENAME)->queryOne();

        $lastId = $queryLastId['lastId'];

        $randomAmount = function () use($faker){
            return $faker->numberBetween(2,5);
        };

        collect($companies)->each(function ($company) use (&$users, $email, $userName, &$lastId,&$authAssignment,$randomAmount){

            $times  = call_user_func($randomAmount);
            $emailInput  = call_user_func($email);

            $id = $lastId++;

            $hashed     = \Yii::$app->security->generatePasswordHash($emailInput);


            $users[]    = [$id, call_user_func($userName), $emailInput , $hashed, $company->id];

            $authAssignment[] = [$id, 'companyAdmin'];

            for ($i = 0; $i < $times; $i++){
                $id = $lastId++;
                $emailInput  = call_user_func($email);
                $hashed     = \Yii::$app->security->generatePasswordHash($emailInput);

                $users[]    = [$id, call_user_func($userName), $emailInput , $hashed, $company->id];

                $authAssignment[] = [$id, 'companyUser'];
            }

        });

        $rQ = count($users);
        $authQ = count($authAssignment);

        $this->table('user')->data($users, ['id','username','email','password_hash','companies_id'])->rowQuantity($rQ);

        $this->table('auth_assignment')->data($authAssignment, ['user_id','item_name'])->rowQuantity($authQ);



    }
}
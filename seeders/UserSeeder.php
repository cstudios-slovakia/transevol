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

        collect($companies)->each(function ($company,$key) use (&$users, $email, $userName, &$lastId,&$authAssignment,$randomAmount){

            $times  = call_user_func($randomAmount);
            $id = $lastId++;

            $user_name      = call_user_func($userName);
            $email_input    = call_user_func($email);

            if($key === 0 ){
                $user_name      = 'demoadmin';
                $email_input    = 'demoadmin@transevol.com';
            }

            $this->makeUser($users, $user_name, $email_input, $company, $id);

            $authAssignment[] = [$id, 'roleCompanyAdmin'];

            for ($i = 0; $i < $times; $i++){
                $id = $lastId++;

                $user_name      = call_user_func($userName);
                $email_input    = call_user_func($email);

                $this->makeUser($users, $user_name, $email_input, $company, $id);


                $authAssignment[] = [$id, 'roleCompanyUser'];
            }

        });

        $rQ = count($users);
        $authQ = count($authAssignment);

        $this->table('user')->data($users, ['id','username','email','password_hash','companies_id'])->rowQuantity($rQ);

        $this->table('auth_assignment')->data($authAssignment, ['user_id','item_name'])->rowQuantity($authQ);




        $authItemData = [
            ['roleCompanyAdmin', 1],
            ['roleCompanyUser', 1],
            ['companyAdmin', 2],
            ['companyUser', 2],
        ];
        $this->table('auth_item')->data($authItemData, ['name','type'])->rowQuantity(count($authItemData));


        $authItemChildData = [
            ['companyAdmin', 'companyUser']
        ];

        $this->table('auth_item_child')->data($authItemChildData, ['parent','child'])->rowQuantity(count($authItemChildData));

    }

    protected function makeUser(&$users,$user_name,$email_input,$company,$id)
    {
        $hashed     = \Yii::$app->security->generatePasswordHash($email_input);
        $users[]    = [$id, $user_name, $email_input , $hashed, $company->id];
    }
}
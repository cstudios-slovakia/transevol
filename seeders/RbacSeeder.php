<?php

namespace app\seeders;

class RbacSeeder extends Seeder
{
    public function run()
    {
        $auth = \Yii::$app->authManager;

//        // add "companyAdmin" permission
//        $companyAdmin = $auth->createPermission('companyAdmin');
//        $companyAdmin->description = 'Company admin permission.';
//        $auth->add($companyAdmin);
//
//        // add "companyUser" permission
//        $companyUser = $auth->createPermission('companyUser');
//        $companyUser->description = 'Company user permission.';
//        $auth->add($companyUser);

        // add "author" role and give this role the "createPost" permission
        $companyAdmin = $auth->createRole('companyAdmin');
        $auth->add($companyAdmin);
//        $auth->addChild($author, $createPost);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $companyUser = $auth->createRole('companyUser');
        $auth->add($companyUser);
//        $auth->addChild($admin, $updatePost);
//        $auth->addChild($admin, $author);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($companyAdmin, 2);
        $auth->assign($companyUser, 1);

//        $company    = function (){
//            return Companies::find()->orderBy(new Expression('rand()'))->one()->id;
//        };
//
//        $this->table('drivers')->columns([
//            'id', //automatic pk
//            'driver_name'=>$this->faker->name,
//            'companies_id'=>call_user_func($company),
//            'email'=>$this->faker->email,
//            'phone'=>$this->faker->phoneNumber,
//            'created_at'    => Carbon::now()->toDateTimeString()
//        ])->rowQuantity(6);

    }
}
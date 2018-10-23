<?php

namespace app\seeders;



class CompanySeeder extends Seeder
{
    public function run()
    {
        $this->table('companies')->columns([
            'id', //automatic pk
            'company_name' => $this->faker->company,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'ico' => $this->faker->creditCardNumber,
            'dic' => $this->faker->creditCardNumber,
            'icdph' => $this->faker->creditCardNumber,
        ])->rowQuantity(5);

    }
}
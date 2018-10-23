<?php

namespace app\seeders;



class CountriesSeeder extends Seeder
{
    public function run()
    {
        $this->table('countries')->columns([
            'id', //automatic pk
            'country_name'=>$this->faker->country
        ])->rowQuantity(6);

    }
}
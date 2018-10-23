<?php

namespace app\seeders;



class UnitSeeder extends Seeder
{
    public function run()
    {
        $this->table('units')->columns([
            'id', //automatic pk
            'unit_name'=>$this->faker->unique()->randomElement(['kg','s','m','km','l','eur'])
        ])->rowQuantity(6);

    }
}
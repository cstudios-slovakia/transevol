<?php

namespace app\seeders;

class FrequencyGroupSeeder extends Seeder
{
    public function run()
    {
        $this->table('frequency_groups')->columns([
            'id', //automatic pk
            'frequency_group_name'=>$this->faker->unique()->randomElement(['length','time','speed','weight']),
            'sorting_number'    => $this->faker->numberBetween(1, 1000)
        ])->rowQuantity(4);

    }
}
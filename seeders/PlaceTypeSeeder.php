<?php

namespace app\seeders;



class PlaceTypeSeeder extends Seeder
{
    public function run()
    {
        $options =
            [
                [1,'toll'],
                [2,'loading'],
                [3,'unloading'],
            ];
        $columnConfig = [false,'placetype_name'];

        $this->table('place_types')->data($options, $columnConfig)->rowQuantity(count($options));

    }
}